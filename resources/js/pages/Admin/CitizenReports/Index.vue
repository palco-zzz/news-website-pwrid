<script setup lang="ts">
import AdminLayout from "@/layouts/AdminLayout.vue";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuPortal,
    DropdownMenuSeparator,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Head, Link, router } from "@inertiajs/vue3";
import {
    AlertTriangle,
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    Circle,
    Clock,
    Eye,
    Loader2,
    MapPin,
    MoreHorizontal,
    Search,
    Trash2,
    XCircle,
} from "lucide-vue-next";
import { computed, ref, watch } from "vue";

defineOptions({ layout: AdminLayout });

interface Reporter {
    id: number;
    name: string;
}

interface CitizenReport {
    id: number;
    title: string;
    slug: string;
    category: string;
    location: string | null;
    reporter_name: string | null;
    reporter: Reporter | null;
    status: "pending" | "verified" | "in_progress" | "resolved" | "rejected";
    is_anonymous: boolean;
    is_published: boolean;
    created_at: string;
}

interface PaginationLinks {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedReports {
    data: CitizenReport[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLinks[];
}

const props = defineProps<{
    reports: PaginatedReports;
    filters?: {
        search?: string;
        status?: string;
        category?: string;
    };
    categories?: string[];
}>();

// Local filter state
const searchQuery = ref(props.filters?.search ?? "");
const statusFilter = ref(props.filters?.status ?? "all");
const categoryFilter = ref(props.filters?.category ?? "all");

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
        "/admin/citizen-reports",
        {
            search: searchQuery.value || undefined,
            status: statusFilter.value !== "all" ? statusFilter.value : undefined,
            category: categoryFilter.value !== "all" ? categoryFilter.value : undefined,
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

// Status configurations
const statusConfig = {
    pending: {
        label: "Pending",
        class: "bg-amber-100 text-amber-700 border-amber-200",
        icon: Clock,
    },
    verified: {
        label: "Terverifikasi",
        class: "bg-blue-100 text-blue-700 border-blue-200",
        icon: CheckCircle2,
    },
    in_progress: {
        label: "Diproses",
        class: "bg-purple-100 text-purple-700 border-purple-200",
        icon: Loader2,
    },
    resolved: {
        label: "Selesai",
        class: "bg-green-100 text-green-700 border-green-200",
        icon: CheckCircle2,
    },
    rejected: {
        label: "Ditolak",
        class: "bg-red-100 text-red-700 border-red-200",
        icon: XCircle,
    },
};

// Category badge colors
const categoryColors: Record<string, string> = {
    Infrastruktur: "bg-orange-100 text-orange-700 border-orange-200",
    Keamanan: "bg-red-100 text-red-700 border-red-200",
    Kebersihan: "bg-green-100 text-green-700 border-green-200",
    Pelayanan: "bg-blue-100 text-blue-700 border-blue-200",
    Kesehatan: "bg-pink-100 text-pink-700 border-pink-200",
    Pendidikan: "bg-indigo-100 text-indigo-700 border-indigo-200",
    Lainnya: "bg-gray-100 text-gray-700 border-gray-200",
};

const getCategoryClass = (category: string) => {
    return categoryColors[category] || categoryColors["Lainnya"];
};

// Get reporter display name
const getReporterName = (report: CitizenReport) => {
    if (report.is_anonymous) {
        return "Anonim";
    }
    return report.reporter?.name ?? report.reporter_name ?? "Unknown";
};

// Format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    }).format(date);
};

// Handle status change
const handleStatusChange = (report: CitizenReport, newStatus: string) => {
    router.patch(
        `/admin/citizen-reports/${report.id}/status`,
        { status: newStatus },
        { preserveScroll: true }
    );
};

// Handle delete action
const handleDelete = (report: CitizenReport) => {
    if (confirm(`Hapus laporan "${report.title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        router.delete(`/admin/citizen-reports/${report.id}`, {
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
const defaultCategories = [
    "Infrastruktur",
    "Keamanan",
    "Kebersihan",
    "Pelayanan",
    "Kesehatan",
    "Pendidikan",
    "Lainnya",
];
const availableCategories = computed(() =>
    props.categories?.length ? props.categories : defaultCategories
);

// Available status options for filter
const statusOptions = [
    { value: "pending", label: "Pending" },
    { value: "verified", label: "Terverifikasi" },
    { value: "in_progress", label: "Diproses" },
    { value: "resolved", label: "Selesai" },
    { value: "rejected", label: "Ditolak" },
];
</script>

<template>

    <Head title="Kelola Laporan Warga" />

    <div class="space-y-6 font-['Plus_Jakarta_Sans']">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Laporan Warga</h1>
                <p class="text-muted-foreground">
                    Kelola dan tindaklanjuti laporan dari masyarakat
                </p>
            </div>
        </div>

        <!-- Filters -->
        <Card>
            <CardHeader class="pb-4">
                <CardTitle class="text-base font-semibold">Filter & Pencarian</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <!-- Search -->
                    <div class="relative flex-1">
                        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                        <Input v-model="searchQuery" type="search" placeholder="Cari judul, pelapor, atau lokasi..."
                            class="pl-9" />
                    </div>

                    <!-- Status Filter -->
                    <Select v-model="statusFilter">
                        <SelectTrigger class="w-full sm:w-[180px]">
                            <SelectValue placeholder="Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua Status</SelectItem>
                            <SelectItem v-for="status in statusOptions" :key="status.value" :value="status.value">
                                {{ status.label }}
                            </SelectItem>
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
                            <TableHead class="w-[250px]">Judul Laporan</TableHead>
                            <TableHead>Pelapor</TableHead>
                            <TableHead>Kategori</TableHead>
                            <TableHead>Lokasi</TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right w-[100px]">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="reports.data.length > 0">
                            <TableRow v-for="report in reports.data" :key="report.id">
                                <TableCell>
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100">
                                            <AlertTriangle class="h-5 w-5 text-amber-600" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium truncate max-w-[180px]">{{ report.title }}</p>
                                            <p class="text-xs text-muted-foreground">ID: {{ report.id }}</p>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-xs font-medium">
                                            {{ getReporterName(report).charAt(0).toUpperCase() }}
                                        </div>
                                        <span class="text-sm">{{ getReporterName(report) }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="getCategoryClass(report.category)">
                                        {{ report.category }}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-1 text-sm text-muted-foreground">
                                        <MapPin class="h-3.5 w-3.5" />
                                        <span class="max-w-[150px] truncate">
                                            {{ report.location || "Tidak disebutkan" }}
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <span class="text-sm text-muted-foreground">
                                        {{ formatDate(report.created_at) }}
                                    </span>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="statusConfig[report.status].class">
                                        <component :is="statusConfig[report.status].icon" class="mr-1 h-3 w-3" />
                                        {{ statusConfig[report.status].label }}
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
                                                <Link :href="`/admin/citizen-reports/${report.id}`"
                                                    class="flex items-center">
                                                    <Eye class="mr-2 h-4 w-4" />
                                                    Lihat Detail
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuSub>
                                                <DropdownMenuSubTrigger>
                                                    <Circle class="mr-2 h-4 w-4" />
                                                    Ubah Status
                                                </DropdownMenuSubTrigger>
                                                <DropdownMenuPortal>
                                                    <DropdownMenuSubContent>
                                                        <DropdownMenuItem v-for="status in statusOptions"
                                                            :key="status.value"
                                                            :disabled="report.status === status.value"
                                                            @click="handleStatusChange(report, status.value)">
                                                            <component
                                                                :is="statusConfig[status.value as keyof typeof statusConfig].icon"
                                                                class="mr-2 h-4 w-4" />
                                                            {{ status.label }}
                                                        </DropdownMenuItem>
                                                    </DropdownMenuSubContent>
                                                </DropdownMenuPortal>
                                            </DropdownMenuSub>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem @click="handleDelete(report)" class="text-destructive">
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
                                <TableCell colspan="7" class="h-32 text-center">
                                    <div class="flex flex-col items-center justify-center text-muted-foreground">
                                        <AlertTriangle class="h-10 w-10 mb-2 opacity-50" />
                                        <p class="font-medium">Tidak ada laporan ditemukan</p>
                                        <p class="text-sm">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </CardContent>

            <!-- Pagination -->
            <div v-if="reports.last_page > 1" class="border-t px-4 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted-foreground">
                        Menampilkan {{ reports.from ?? 0 }} - {{ reports.to ?? 0 }} dari
                        {{ reports.total }} laporan
                    </p>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm" :disabled="reports.current_page === 1"
                            @click="goToPage(reports.links[0]?.url)">
                            <ChevronLeft class="h-4 w-4" />
                            Sebelumnya
                        </Button>

                        <div class="hidden sm:flex items-center gap-1">
                            <template v-for="(link, index) in reports.links.slice(1, -1)" :key="index">
                                <Button v-if="link.url" variant="outline" size="sm"
                                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                                    @click="goToPage(link.url)">
                                    {{ link.label }}
                                </Button>
                                <span v-else class="px-2 text-muted-foreground">...</span>
                            </template>
                        </div>

                        <span class="sm:hidden text-sm text-muted-foreground">
                            {{ reports.current_page }} / {{ reports.last_page }}
                        </span>

                        <Button variant="outline" size="sm" :disabled="reports.current_page === reports.last_page"
                            @click="goToPage(reports.links[reports.links.length - 1]?.url)">
                            Selanjutnya
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>

<style scoped>
/* Ensure Plus Jakarta Sans is applied */
.font-\[\'Plus_Jakarta_Sans\'\] {
    font-family: "Plus Jakarta Sans", sans-serif;
}
</style>
