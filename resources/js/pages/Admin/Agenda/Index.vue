<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import {
    Calendar,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    Clock,
    Edit,
    Eye,
    Loader2,
    MapPin,
    MoreHorizontal,
    Plus,
    Search,
    Trash2,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

interface Agenda {
    id: number;
    title: string;
    slug: string;
    date: string;
    time: string;
    location: string;
    category: string;
    status: 'draft' | 'published';
    created_at: string;
}

interface PaginationLinks {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedAgenda {
    data: Agenda[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLinks[];
}

const props = defineProps<{
    agendaList?: PaginatedAgenda;
    filters?: {
        search?: string;
        status?: string;
    };
    stats?: {
        total: number;
        upcoming: number;
        completed: number;
    };
}>();

// Placeholder data - will be replaced with actual props from controller
const defaultAgendaList: Agenda[] = [
    {
        id: 1,
        title: 'Rapat Koordinasi Desa',
        slug: 'rapat-koordinasi-desa',
        date: '2026-01-15',
        time: '09:00',
        location: 'Balai Desa Purworejo',
        category: 'Pemerintahan',
        status: 'published',
        created_at: '2026-01-01',
    },
    {
        id: 2,
        title: 'Festival Budaya Purworejo',
        slug: 'festival-budaya-purworejo',
        date: '2026-01-20',
        time: '08:00',
        location: 'Alun-alun Purworejo',
        category: 'Budaya',
        status: 'published',
        created_at: '2026-01-02',
    },
    {
        id: 3,
        title: 'Bazar UMKM Mingguan',
        slug: 'bazar-umkm-mingguan',
        date: '2026-01-22',
        time: '07:00',
        location: 'Pasar Baledono',
        category: 'Ekonomi',
        status: 'draft',
        created_at: '2026-01-03',
    },
    {
        id: 4,
        title: 'Posyandu Balita',
        slug: 'posyandu-balita',
        date: '2026-01-25',
        time: '08:00',
        location: 'Puskesmas Purworejo',
        category: 'Kesehatan',
        status: 'published',
        created_at: '2026-01-04',
    },
    {
        id: 5,
        title: 'Turnamen Sepak Bola Antar Desa',
        slug: 'turnamen-sepak-bola',
        date: '2026-01-28',
        time: '14:00',
        location: 'Lapangan Desa Kutoarjo',
        category: 'Olahraga',
        status: 'draft',
        created_at: '2026-01-05',
    },
];

// Use props or fallback to default data
const agendaData = computed(() => props.agendaList?.data ?? defaultAgendaList);
const stats = computed(() => props.stats ?? {
    total: defaultAgendaList.length,
    upcoming: defaultAgendaList.filter(a => a.status === 'published').length,
    completed: 0,
});

// Local filter state
const searchQuery = ref(props.filters?.search ?? '');
const statusFilter = ref(props.filters?.status ?? 'all');

// Debounced search
let searchTimeout: ReturnType<typeof setTimeout>;
watch(searchQuery, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 300);
});

// Apply filters
const applyFilters = () => {
    router.get(
        '/admin/agenda',
        {
            search: searchQuery.value || undefined,
            status: statusFilter.value !== 'all' ? statusFilter.value : undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// Watch filter changes
watch(statusFilter, () => {
    applyFilters();
});

// Filtered data (for placeholder without backend)
const filteredAgenda = computed(() => {
    let result = agendaData.value;

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter(
            (agenda) =>
                agenda.title.toLowerCase().includes(query) ||
                agenda.location.toLowerCase().includes(query)
        );
    }

    if (statusFilter.value !== 'all') {
        result = result.filter((agenda) => agenda.status === statusFilter.value);
    }

    return result;
});

// Format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }).format(date);
};

const formatShortDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
};

// Status badge config
const getStatusBadge = (status: string) => {
    if (status === 'published') {
        return { label: 'Published', class: 'bg-green-100 text-green-700 border-green-200' };
    }
    return { label: 'Draft', class: 'bg-amber-100 text-amber-700 border-amber-200' };
};

// Category colors
const getCategoryColor = (category: string) => {
    const colors: Record<string, string> = {
        Pemerintahan: 'bg-blue-100 text-blue-700 border-blue-200',
        Budaya: 'bg-purple-100 text-purple-700 border-purple-200',
        Ekonomi: 'bg-green-100 text-green-700 border-green-200',
        Pendidikan: 'bg-amber-100 text-amber-700 border-amber-200',
        Kesehatan: 'bg-red-100 text-red-700 border-red-200',
        Olahraga: 'bg-orange-100 text-orange-700 border-orange-200',
    };
    return colors[category] || 'bg-gray-100 text-gray-700 border-gray-200';
};

// Handle delete action
const handleDelete = (agenda: Agenda) => {
    if (confirm(`Hapus agenda "${agenda.title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        router.delete(`/admin/agenda/${agenda.id}`, {
            preserveScroll: true,
        });
    }
};

// Pagination
const goToPage = (url: string | null) => {
    if (url) {
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    }
};

// Create Agenda Modal
const isCreateDialogOpen = ref(false);

// Form state using Inertia's useForm
const createForm = useForm({
    title: '',
    date: '',
    time: '',
    location: '',
    description: '',
    category: 'Pemerintahan',
    status: 'draft' as 'draft' | 'published',
});

// Available categories for the form
const categoryOptions = [
    'Pemerintahan',
    'Budaya',
    'Ekonomi',
    'Pendidikan',
    'Kesehatan',
    'Olahraga',
    'Lainnya',
];

// Submit create form
const submitCreateForm = () => {
    createForm.post('/admin/agenda', {
        preserveScroll: true,
        onSuccess: () => {
            isCreateDialogOpen.value = false;
            createForm.reset();
        },
    });
};

// Reset form when dialog closes
const handleDialogChange = (open: boolean) => {
    isCreateDialogOpen.value = open;
    if (!open) {
        createForm.reset();
        createForm.clearErrors();
    }
};
</script>

<template>

    <Head title="Kelola Agenda" />

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Agenda & Kegiatan</h1>
                <p class="text-muted-foreground">
                    Kelola jadwal kegiatan dan acara di Purworejo
                </p>
            </div>

            <!-- Create Agenda Dialog -->
            <Dialog :open="isCreateDialogOpen" @update:open="handleDialogChange">
                <DialogTrigger as-child>
                    <Button>
                        <Plus class="mr-2 h-4 w-4" />
                        Tambah Agenda
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[525px]">
                    <DialogHeader>
                        <DialogTitle>Tambah Agenda Baru</DialogTitle>
                        <DialogDescription>
                            Buat agenda atau kegiatan baru untuk ditampilkan di portal.
                        </DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="submitCreateForm" class="space-y-4 py-4">
                        <!-- Title -->
                        <div class="space-y-2">
                            <Label for="title">
                                Judul Agenda <span class="text-destructive">*</span>
                            </Label>
                            <Input id="title" v-model="createForm.title" placeholder="Masukkan judul agenda..."
                                :class="{ 'border-destructive': createForm.errors.title }" />
                            <p v-if="createForm.errors.title" class="text-sm text-destructive">
                                {{ createForm.errors.title }}
                            </p>
                        </div>

                        <!-- Date & Time Row -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Date -->
                            <div class="space-y-2">
                                <Label for="date">
                                    Tanggal <span class="text-destructive">*</span>
                                </Label>
                                <Input id="date" type="date" v-model="createForm.date"
                                    :class="{ 'border-destructive': createForm.errors.date }" />
                                <p v-if="createForm.errors.date" class="text-sm text-destructive">
                                    {{ createForm.errors.date }}
                                </p>
                            </div>

                            <!-- Time -->
                            <div class="space-y-2">
                                <Label for="time">Waktu</Label>
                                <Input id="time" type="time" v-model="createForm.time"
                                    :class="{ 'border-destructive': createForm.errors.time }" />
                                <p v-if="createForm.errors.time" class="text-sm text-destructive">
                                    {{ createForm.errors.time }}
                                </p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="space-y-2">
                            <Label for="location">
                                Lokasi <span class="text-destructive">*</span>
                            </Label>
                            <Input id="location" v-model="createForm.location" placeholder="Masukkan lokasi acara..."
                                :class="{ 'border-destructive': createForm.errors.location }" />
                            <p v-if="createForm.errors.location" class="text-sm text-destructive">
                                {{ createForm.errors.location }}
                            </p>
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <Label for="category">Kategori</Label>
                            <Select v-model="createForm.category">
                                <SelectTrigger :class="{ 'border-destructive': createForm.errors.category }">
                                    <SelectValue placeholder="Pilih kategori" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categoryOptions" :key="category" :value="category">
                                        {{ category }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="createForm.errors.category" class="text-sm text-destructive">
                                {{ createForm.errors.category }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Deskripsi</Label>
                            <Textarea id="description" v-model="createForm.description"
                                placeholder="Tulis deskripsi singkat tentang agenda ini..." :rows="4"
                                :class="{ 'border-destructive': createForm.errors.description }" />
                            <p v-if="createForm.errors.description" class="text-sm text-destructive">
                                {{ createForm.errors.description }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <Label for="status">Status</Label>
                            <Select v-model="createForm.status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="draft">Draft</SelectItem>
                                    <SelectItem value="published">Published</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <DialogFooter class="pt-4">
                            <Button type="button" variant="outline" @click="isCreateDialogOpen = false"
                                :disabled="createForm.processing">
                                Batal
                            </Button>
                            <Button type="submit" :disabled="createForm.processing">
                                <Loader2 v-if="createForm.processing" class="mr-2 h-4 w-4 animate-spin" />
                                {{ createForm.processing ? 'Menyimpan...' : 'Simpan Agenda' }}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-3">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Agenda</CardTitle>
                    <CalendarDays class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.total }}</div>
                    <p class="text-xs text-muted-foreground">
                        Bulan ini
                    </p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Mendatang</CardTitle>
                    <Calendar class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.upcoming }}</div>
                    <p class="text-xs text-muted-foreground">
                        7 hari ke depan
                    </p>
                </CardContent>
            </Card>
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Selesai</CardTitle>
                    <Clock class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats.completed }}</div>
                    <p class="text-xs text-muted-foreground">
                        Bulan ini
                    </p>
                </CardContent>
            </Card>
        </div>

        <!-- Filters -->
        <Card>
            <CardHeader class="pb-4">
                <CardTitle class="text-base">Filter & Pencarian</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <!-- Search -->
                    <div class="relative flex-1">
                        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                        <Input v-model="searchQuery" type="search" placeholder="Cari nama agenda atau lokasi..."
                            class="pl-9" />
                    </div>

                    <!-- Status Filter -->
                    <Select v-model="statusFilter">
                        <SelectTrigger class="w-full sm:w-[180px]">
                            <SelectValue placeholder="Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua Status</SelectItem>
                            <SelectItem value="published">Published</SelectItem>
                            <SelectItem value="draft">Draft</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </CardContent>
        </Card>

        <!-- Data Table -->
        <Card>
            <CardContent class="p-0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[300px]">Nama Agenda</TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead>Lokasi</TableHead>
                            <TableHead>Kategori</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right w-[100px]">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="filteredAgenda.length > 0">
                            <TableRow v-for="agenda in filteredAgenda" :key="agenda.id">
                                <TableCell>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100">
                                            <Calendar class="h-5 w-5 text-indigo-600" />
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ agenda.title }}</p>
                                            <p class="text-xs text-muted-foreground">
                                                {{ agenda.time }} WIB
                                            </p>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ formatShortDate(agenda.date) }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-1 text-sm text-muted-foreground">
                                        <MapPin class="h-3.5 w-3.5" />
                                        <span class="max-w-[150px] truncate">{{ agenda.location }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="getCategoryColor(agenda.category)">
                                        {{ agenda.category }}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="getStatusBadge(agenda.status).class">
                                        {{ getStatusBadge(agenda.status).label }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button variant="ghost" size="icon" class="h-8 w-8">
                                                <MoreHorizontal class="h-4 w-4" />
                                                <span class="sr-only">Open menu</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuLabel>Aksi</DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem as-child>
                                                <Link :href="`/admin/agenda/${agenda.id}/edit`"
                                                    class="flex items-center">
                                                    <Edit class="mr-2 h-4 w-4" />
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem as-child>
                                                <a :href="`/agenda/${agenda.slug}`" target="_blank"
                                                    class="flex items-center">
                                                    <Eye class="mr-2 h-4 w-4" />
                                                    Lihat
                                                </a>
                                            </DropdownMenuItem>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem @click="handleDelete(agenda)" class="text-destructive">
                                                <Trash2 class="mr-2 h-4 w-4" />
                                                Hapus
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell colspan="6" class="h-32 text-center">
                                    <div class="flex flex-col items-center justify-center text-muted-foreground">
                                        <Calendar class="h-10 w-10 mb-2 opacity-50" />
                                        <p class="font-medium">Tidak ada agenda ditemukan</p>
                                        <p class="text-sm">Coba ubah filter atau tambah agenda baru</p>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </CardContent>

            <!-- Pagination -->
            <div v-if="agendaList && agendaList.last_page > 1" class="border-t px-4 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted-foreground">
                        Menampilkan {{ agendaList.from ?? 0 }} - {{ agendaList.to ?? 0 }} dari {{ agendaList.total }}
                        data
                    </p>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm" :disabled="agendaList.current_page === 1"
                            @click="goToPage(agendaList.links[0]?.url)">
                            <ChevronLeft class="h-4 w-4" />
                            Sebelumnya
                        </Button>

                        <div class="hidden sm:flex items-center gap-1">
                            <template v-for="(link, index) in agendaList.links.slice(1, -1)" :key="index">
                                <Button v-if="link.url" variant="outline" size="sm"
                                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                                    @click="goToPage(link.url)">
                                    {{ link.label }}
                                </Button>
                                <span v-else class="px-2 text-muted-foreground">...</span>
                            </template>
                        </div>

                        <span class="sm:hidden text-sm text-muted-foreground">
                            {{ agendaList.current_page }} / {{ agendaList.last_page }}
                        </span>

                        <Button variant="outline" size="sm" :disabled="agendaList.current_page === agendaList.last_page"
                            @click="goToPage(agendaList.links[agendaList.links.length - 1]?.url)">
                            Selanjutnya
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>
