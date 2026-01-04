<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Calendar,
    CheckCircle,
    Clock,
    FileText,
    Megaphone,
    PenLine,
    ShieldCheck,
    Store,
} from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({ layout: AdminLayout });

interface CitizenReport {
    id: number;
    title: string;
    slug: string;
    reporter_name: string | null;
    category: string;
    status: 'pending' | 'verified' | 'in_progress' | 'resolved' | 'rejected';
    is_anonymous: boolean;
    created_at: string;
}

const props = defineProps<{
    stats?: {
        totalNews: number;
        totalUmkm: number;
        totalReports: number;
        totalAgenda: number;
    };
    recentReports?: CitizenReport[];
}>();

// Status badge variants
const getStatusBadge = (status: string) => {
    const statusConfig: Record<string, { label: string; variant: 'default' | 'secondary' | 'outline' | 'destructive'; class: string }> = {
        pending: { label: 'Menunggu', variant: 'secondary', class: 'bg-amber-100 text-amber-700 border-amber-200' },
        verified: { label: 'Terverifikasi', variant: 'default', class: 'bg-blue-100 text-blue-700 border-blue-200' },
        in_progress: { label: 'Diproses', variant: 'secondary', class: 'bg-purple-100 text-purple-700 border-purple-200' },
        resolved: { label: 'Selesai', variant: 'default', class: 'bg-green-100 text-green-700 border-green-200' },
        rejected: { label: 'Ditolak', variant: 'destructive', class: 'bg-red-100 text-red-700 border-red-200' },
    };
    return statusConfig[status] || { label: status, variant: 'outline' as const, class: '' };
};

// Format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};

// Format relative time
const formatRelativeTime = (dateString: string) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now.getTime() - date.getTime()) / 1000);

    if (diffInSeconds < 60) return 'Baru saja';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} menit lalu`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} jam lalu`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} hari lalu`;
    return formatDate(dateString);
};
</script>

<template>

    <Head title="Admin Dashboard" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Dashboard</h1>
            <p class="text-muted-foreground">
                Selamat datang kembali! Berikut ringkasan portal berita Anda.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Berita</CardTitle>
                    <FileText class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats?.totalNews ?? 0 }}</div>
                    <p class="text-xs text-muted-foreground">
                        <span class="text-green-600">+12%</span> dari bulan lalu
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">UMKM Terdaftar</CardTitle>
                    <Store class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats?.totalUmkm ?? 0 }}</div>
                    <p class="text-xs text-muted-foreground">
                        <span class="text-green-600">+8%</span> dari bulan lalu
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Laporan Warga Aktif</CardTitle>
                    <Megaphone class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats?.totalReports ?? 0 }}</div>
                    <p class="text-xs text-muted-foreground">
                        <span class="text-amber-600">Perlu ditinjau</span>
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Agenda</CardTitle>
                    <Calendar class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ stats?.totalAgenda ?? 0 }}</div>
                    <p class="text-xs text-muted-foreground">
                        <span class="text-blue-600">Acara mendatang</span>
                    </p>
                </CardContent>
            </Card>
        </div>

        <!-- Recent Activity Table & Quick Actions -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Recent Activity Table -->
            <Card class="lg:col-span-2">
                <CardHeader class="flex flex-row items-center justify-between">
                    <div>
                        <CardTitle>Laporan Warga Terbaru</CardTitle>
                        <CardDescription>
                            5 laporan terakhir dari fitur "Lapor Lur!"
                        </CardDescription>
                    </div>
                    <Button variant="outline" size="sm" as-child>
                        <Link href="/admin/citizen-reports">
                            Lihat Semua
                            <ArrowRight class="ml-1 h-4 w-4" />
                        </Link>
                    </Button>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Judul Laporan</TableHead>
                                <TableHead>Pelapor</TableHead>
                                <TableHead>Kategori</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Waktu</TableHead>
                                <TableHead class="text-right">Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-if="recentReports && recentReports.length > 0">
                                <TableRow v-for="report in recentReports" :key="report.id">
                                    <TableCell class="font-medium max-w-[200px] truncate">
                                        {{ report.title }}
                                    </TableCell>
                                    <TableCell>
                                        <span v-if="report.is_anonymous" class="text-muted-foreground italic">
                                            Anonim
                                        </span>
                                        <span v-else>{{ report.reporter_name || '-' }}</span>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant="outline" class="text-xs">
                                            {{ report.category }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        <Badge :variant="getStatusBadge(report.status).variant"
                                            :class="getStatusBadge(report.status).class">
                                            {{ getStatusBadge(report.status).label }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell class="text-muted-foreground text-sm">
                                        {{ formatRelativeTime(report.created_at) }}
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <Button variant="ghost" size="sm" as-child>
                                            <a v-if="report.slug" :href="`/laporan-warga/${report.slug}`"
                                                target="_blank">
                                                Lihat
                                            </a>
                                            <span v-else class="text-muted-foreground text-xs">No Slug</span>
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </template>
                            <template v-else>
                                <TableRow>
                                    <TableCell colspan="6" class="text-center py-8 text-muted-foreground">
                                        <Megaphone class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                        <p>Belum ada laporan warga</p>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <!-- Quick Actions -->
            <Card>
                <CardHeader>
                    <CardTitle>Aksi Cepat</CardTitle>
                    <CardDescription>
                        Pintasan untuk tugas umum
                    </CardDescription>
                </CardHeader>
                <CardContent class="space-y-3">
                    <Button variant="outline" class="w-full justify-start h-auto py-3" as-child>
                        <Link href="/admin/news/create">
                            <PenLine class="h-4 w-4 text-indigo-600" />
                            <div class="flex flex-col items-start ml-2">
                                <span class="font-medium">Tulis Berita</span>
                                <span class="text-xs text-muted-foreground">Buat artikel berita baru</span>
                            </div>
                        </Link>
                    </Button>

                    <Button variant="outline" class="w-full justify-start h-auto py-3" as-child>
                        <Link href="/admin/umkm?filter=pending">
                            <ShieldCheck class="h-4 w-4 text-green-600" />
                            <div class="flex flex-col items-start ml-2">
                                <span class="font-medium">Verifikasi UMKM</span>
                                <span class="text-xs text-muted-foreground">Tinjau pendaftaran UMKM</span>
                            </div>
                        </Link>
                    </Button>

                    <Button variant="outline" class="w-full justify-start h-auto py-3" as-child>
                        <Link href="/admin/citizen-reports?status=pending">
                            <Clock class="h-4 w-4 text-amber-600" />
                            <div class="flex flex-col items-start ml-2">
                                <span class="font-medium">Review Laporan</span>
                                <span class="text-xs text-muted-foreground">Tinjau laporan pending</span>
                            </div>
                        </Link>
                    </Button>

                    <Button variant="outline" class="w-full justify-start h-auto py-3" as-child>
                        <Link href="/admin/agenda/create">
                            <Calendar class="h-4 w-4 text-purple-600" />
                            <div class="flex flex-col items-start ml-2">
                                <span class="font-medium">Buat Agenda</span>
                                <span class="text-xs text-muted-foreground">Tambah acara baru</span>
                            </div>
                        </Link>
                    </Button>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
