<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
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
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ChevronLeft,
    ChevronRight,
    Edit,
    MapPin,
    MoreHorizontal,
    Plus,
    Search,
    ShieldCheck,
    Store,
    Trash2,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

interface Umkm {
    id: number;
    name: string;
    slug: string;
    category: string;
    address: string | null;
    is_verified: boolean;
    is_active: boolean;
    created_at: string;
}

interface PaginationLinks {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedUmkm {
    data: Umkm[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLinks[];
}

const props = defineProps<{
    umkmList: PaginatedUmkm;
    filters?: {
        search?: string;
        status?: string;
        category?: string;
    };
    categories?: string[];
}>();

// Local filter state
const searchQuery = ref(props.filters?.search ?? '');
const statusFilter = ref(props.filters?.status ?? 'all');
const categoryFilter = ref(props.filters?.category ?? 'all');

// Debounced search
let searchTimeout: ReturnType<typeof setTimeout>;
watch(searchQuery, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 300);
});

// Apply filters
const applyFilters = () => {
    router.get(
        '/admin/umkm',
        {
            search: searchQuery.value || undefined,
            status: statusFilter.value !== 'all' ? statusFilter.value : undefined,
            category: categoryFilter.value !== 'all' ? categoryFilter.value : undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// Watch filter changes
watch([statusFilter, categoryFilter], () => {
    applyFilters();
});

// Status badge config
const getStatusBadge = (isVerified: boolean) => {
    if (isVerified) {
        return { label: 'Terverifikasi', class: 'bg-green-100 text-green-700 border-green-200' };
    }
    return { label: 'Pending', class: 'bg-amber-100 text-amber-700 border-amber-200' };
};

// Handle verify action
const handleVerify = (umkm: Umkm) => {
    if (confirm(`Verifikasi UMKM "${umkm.name}"?`)) {
        router.patch(`/admin/umkm/${umkm.id}/verify`, {}, {
            preserveScroll: true,
        });
    }
};

// Handle delete action
const handleDelete = (umkm: Umkm) => {
    if (confirm(`Hapus UMKM "${umkm.name}"? Tindakan ini tidak dapat dibatalkan.`)) {
        router.delete(`/admin/umkm/${umkm.id}`, {
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

// Default categories
const defaultCategories = ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Lainnya'];
const availableCategories = computed(() => props.categories ?? defaultCategories);
</script>

<template>

    <Head title="Kelola UMKM" />

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kelola UMKM</h1>
                <p class="text-muted-foreground">
                    Kelola dan verifikasi UMKM yang terdaftar di portal
                </p>
            </div>
            <Button as-child>
                <Link href="/admin/umkm/create">
                    <Plus class="mr-2 h-4 w-4" />
                    Tambah UMKM
                </Link>
            </Button>
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
                        <Input v-model="searchQuery" type="search" placeholder="Cari nama UMKM..." class="pl-9" />
                    </div>

                    <!-- Status Filter -->
                    <Select v-model="statusFilter">
                        <SelectTrigger class="w-full sm:w-[180px]">
                            <SelectValue placeholder="Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua Status</SelectItem>
                            <SelectItem value="verified">Terverifikasi</SelectItem>
                            <SelectItem value="pending">Pending</SelectItem>
                        </SelectContent>
                    </Select>

                    <!-- Category Filter -->
                    <Select v-model="categoryFilter">
                        <SelectTrigger class="w-full sm:w-[180px]">
                            <SelectValue placeholder="Kategori" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua Kategori</SelectItem>
                            <SelectItem v-for="category in availableCategories" :key="category" :value="category">
                                {{ category }}
                            </SelectItem>
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
                            <TableHead class="w-[300px]">Nama UMKM</TableHead>
                            <TableHead>Kategori</TableHead>
                            <TableHead>Lokasi</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right w-[100px]">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="umkmList.data.length > 0">
                            <TableRow v-for="umkm in umkmList.data" :key="umkm.id">
                                <TableCell>
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                                            <Store class="h-5 w-5 text-green-600" />
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ umkm.name }}</p>
                                            <p class="text-xs text-muted-foreground">
                                                ID: {{ umkm.id }}
                                            </p>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline">{{ umkm.category }}</Badge>
                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-1 text-sm text-muted-foreground">
                                        <MapPin class="h-3.5 w-3.5" />
                                        <span class="max-w-[200px] truncate">
                                            {{ umkm.address || 'Belum diisi' }}
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="getStatusBadge(umkm.is_verified).class">
                                        {{ getStatusBadge(umkm.is_verified).label }}
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
                                                <Link :href="`/admin/umkm/${umkm.id}/edit`" class="flex items-center">
                                                    <Edit class="mr-2 h-4 w-4" />
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem v-if="!umkm.is_verified" @click="handleVerify(umkm)"
                                                class="text-green-600">
                                                <ShieldCheck class="mr-2 h-4 w-4" />
                                                Verifikasi
                                            </DropdownMenuItem>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem @click="handleDelete(umkm)" class="text-destructive">
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
                                <TableCell colspan="5" class="h-32 text-center">
                                    <div class="flex flex-col items-center justify-center text-muted-foreground">
                                        <Store class="h-10 w-10 mb-2 opacity-50" />
                                        <p class="font-medium">Tidak ada UMKM ditemukan</p>
                                        <p class="text-sm">Coba ubah filter atau tambah UMKM baru</p>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </CardContent>

            <!-- Pagination -->
            <div v-if="umkmList.last_page > 1" class="border-t px-4 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted-foreground">
                        Menampilkan {{ umkmList.from ?? 0 }} - {{ umkmList.to ?? 0 }} dari {{ umkmList.total }} data
                    </p>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm" :disabled="umkmList.current_page === 1"
                            @click="goToPage(umkmList.links[0]?.url)">
                            <ChevronLeft class="h-4 w-4" />
                            Sebelumnya
                        </Button>

                        <div class="hidden sm:flex items-center gap-1">
                            <template v-for="(link, index) in umkmList.links.slice(1, -1)" :key="index">
                                <Button v-if="link.url" variant="outline" size="sm"
                                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                                    @click="goToPage(link.url)">
                                    {{ link.label }}
                                </Button>
                                <span v-else class="px-2 text-muted-foreground">...</span>
                            </template>
                        </div>

                        <span class="sm:hidden text-sm text-muted-foreground">
                            {{ umkmList.current_page }} / {{ umkmList.last_page }}
                        </span>

                        <Button variant="outline" size="sm" :disabled="umkmList.current_page === umkmList.last_page"
                            @click="goToPage(umkmList.links[umkmList.links.length - 1]?.url)">
                            Selanjutnya
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>
