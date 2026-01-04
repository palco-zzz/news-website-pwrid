<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
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
import { Checkbox } from '@/components/ui/checkbox';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ChevronLeft,
    ChevronRight,
    Edit,
    Eye,
    Flame,
    MoreHorizontal,
    Newspaper,
    Plus,
    Search,
    Star,
    Trash2,
    Sparkles,
    TrendingUp,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

interface Author {
    id: number;
    name: string;
}

interface News {
    id: number;
    title: string;
    slug: string;
    category: string;
    status: 'draft' | 'published' | 'archived';
    is_headline: boolean;
    is_trending: boolean;
    views_count: number;
    published_at: string | null;
    created_at: string;
    author: Author | null;
}

interface SimpleNews {
    id: number;
    title: string;
    slug: string;
    is_headline: boolean;
    is_trending: boolean;
}

interface PaginationLinks {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedNews {
    data: News[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLinks[];
}

const props = defineProps<{
    newsList: PaginatedNews;
    filters?: {
        search?: string;
        status?: string;
        category?: string;
    };
    categories?: string[];
    currentHeadline?: News | null;
    trendingNews?: News[];
    allPublishedNews?: SimpleNews[];
}>();

// Local filter state
const searchQuery = ref(props.filters?.search ?? '');
const statusFilter = ref(props.filters?.status ?? 'all');
const categoryFilter = ref(props.filters?.category ?? 'all');

// Featured management state
const selectedHeadline = ref<string>(props.currentHeadline?.id?.toString() ?? '');
const selectedTrending = ref<number[]>(props.trendingNews?.map(n => n.id) ?? []);

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
        '/admin/news',
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
const getStatusBadge = (status: string) => {
    switch (status) {
        case 'published':
            return { label: 'Terbit', class: 'bg-green-100 text-green-700 border-green-200' };
        case 'draft':
            return { label: 'Draft', class: 'bg-amber-100 text-amber-700 border-amber-200' };
        case 'archived':
            return { label: 'Diarsipkan', class: 'bg-gray-100 text-gray-700 border-gray-200' };
        default:
            return { label: status, class: '' };
    }
};

// Format date
const formatDate = (dateString: string | null) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
};

// Format views count
const formatViews = (count: number) => {
    if (count >= 1000000) {
        return (count / 1000000).toFixed(1) + 'M';
    }
    if (count >= 1000) {
        return (count / 1000).toFixed(1) + 'K';
    }
    return count.toString();
};

// Handle delete action
const handleDelete = (news: News) => {
    if (confirm(`Hapus berita "${news.title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        router.delete(`/admin/news/${news.id}`, {
            preserveScroll: true,
        });
    }
};

// Toggle headline/trending status
const toggleStatus = (news: News, field: 'is_headline' | 'is_trending') => {
    router.patch(`/admin/news/${news.id}/toggle/${field}`, {}, {
        preserveScroll: true,
    });
};

// Set headline
const updateHeadline = () => {
    router.post('/admin/news/set-headline', {
        news_id: selectedHeadline.value ? parseInt(selectedHeadline.value) : null,
    }, {
        preserveScroll: true,
    });
};

// Toggle trending checkbox
const isTrendingSelected = (newsId: number) => {
    return selectedTrending.value.includes(newsId);
};

const toggleTrendingSelection = (newsId: number) => {
    if (selectedTrending.value.includes(newsId)) {
        selectedTrending.value = selectedTrending.value.filter(id => id !== newsId);
    } else {
        selectedTrending.value = [...selectedTrending.value, newsId];
    }
};

const updateTrending = () => {
    router.post('/admin/news/set-trending', {
        news_ids: selectedTrending.value,
    }, {
        preserveScroll: true,
    });
};

// Featured search filter (unified for headline and trending)
const featuredSearchQuery = ref('');

const filteredNewsForFeatured = computed(() => {
    if (!props.allPublishedNews || !featuredSearchQuery.value) return [];

    const query = featuredSearchQuery.value.toLowerCase();
    return props.allPublishedNews.filter(n => n.title.toLowerCase().includes(query));
});

// Quick toggle - instantly toggle headline or trending
const quickToggle = (newsId: number, field: 'is_headline' | 'is_trending') => {
    router.patch(`/admin/news/${newsId}/toggle/${field}`, {}, {
        preserveScroll: true,
    });
};

// Pagination
const goToPage = (url: string | null) => {
    if (url) {
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    }
};

// Default categories
const defaultCategories = ['Politik', 'Ekonomi', 'Olahraga', 'Pendidikan', 'Kesehatan', 'Budaya', 'Lainnya'];
const availableCategories = computed(() => props.categories ?? defaultCategories);
</script>

<template>

    <Head title="Kelola Berita" />

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Kelola Berita</h1>
                <p class="text-muted-foreground">
                    Kelola artikel berita yang dipublikasikan di portal
                </p>
            </div>
            <Button as-child>
                <Link href="/admin/news/create">
                    <Plus class="mr-2 h-4 w-4" />
                    Tulis Berita
                </Link>
            </Button>
        </div>

        <!-- Quick Featured Toggle -->
        <Card>
            <CardHeader class="pb-3">
                <CardTitle class="text-base flex items-center gap-2">
                    <Sparkles class="h-5 w-5 text-indigo-600" />
                    Atur Headline & Trending
                </CardTitle>
                <CardDescription>Cari berita lalu klik ikon untuk toggle Headline atau Trending</CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <!-- Current Status -->
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <Star class="h-4 w-4 text-yellow-600 fill-yellow-600" />
                        <span class="text-muted-foreground">Headline:</span>
                        <span class="font-medium">{{ currentHeadline?.title ? (currentHeadline.title.length > 30 ?
                            currentHeadline.title.substring(0, 30) + '...' : currentHeadline.title) : 'Belum dipilih'
                        }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Flame class="h-4 w-4 text-orange-600" />
                        <span class="text-muted-foreground">Trending:</span>
                        <span class="font-medium">{{ trendingNews?.length || 0 }} berita aktif</span>
                    </div>
                </div>

                <!-- Search -->
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input v-model="featuredSearchQuery" type="search"
                        placeholder="Cari berita untuk diatur headline/trending..." class="pl-9" />
                </div>

                <!-- Results List -->
                <div v-if="featuredSearchQuery" class="border rounded-lg divide-y max-h-[300px] overflow-y-auto">
                    <div v-for="news in filteredNewsForFeatured" :key="`f-${news.id}`"
                        class="flex items-center justify-between p-3 hover:bg-slate-50 transition-colors">
                        <div class="flex-1 min-w-0 mr-4">
                            <p class="text-sm font-medium truncate">{{ news.title }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <!-- Headline Toggle -->
                            <Button variant="ghost" size="sm" class="h-8 w-8 p-0"
                                :class="news.is_headline ? 'text-yellow-600 bg-yellow-50' : 'text-slate-400 hover:text-yellow-600'"
                                @click="quickToggle(news.id, 'is_headline')"
                                :title="news.is_headline ? 'Hapus dari Headline' : 'Jadikan Headline'">
                                <Star class="h-4 w-4" :class="news.is_headline ? 'fill-yellow-600' : ''" />
                            </Button>
                            <!-- Trending Toggle -->
                            <Button variant="ghost" size="sm" class="h-8 w-8 p-0"
                                :class="news.is_trending ? 'text-orange-600 bg-orange-50' : 'text-slate-400 hover:text-orange-600'"
                                @click="quickToggle(news.id, 'is_trending')"
                                :title="news.is_trending ? 'Hapus dari Trending' : 'Jadikan Trending'">
                                <Flame class="h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                    <p v-if="filteredNewsForFeatured.length === 0"
                        class="p-4 text-sm text-muted-foreground text-center">
                        Tidak ada berita ditemukan
                    </p>
                </div>

                <!-- Hint when no search -->
                <p v-else class="text-sm text-muted-foreground text-center py-2">
                    Ketik untuk mencari berita yang ingin diatur
                </p>
            </CardContent>
        </Card>

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
                        <Input v-model="searchQuery" type="search" placeholder="Cari judul berita..." class="pl-9" />
                    </div>

                    <!-- Status Filter -->
                    <Select v-model="statusFilter">
                        <SelectTrigger class="w-full sm:w-[180px]">
                            <SelectValue placeholder="Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Semua Status</SelectItem>
                            <SelectItem value="published">Terbit</SelectItem>
                            <SelectItem value="draft">Draft</SelectItem>
                            <SelectItem value="archived">Diarsipkan</SelectItem>
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
                            <TableHead class="w-[350px]">Judul</TableHead>
                            <TableHead>Kategori</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>
                                <div class="flex items-center gap-1">
                                    <Eye class="h-4 w-4" />
                                    Views
                                </div>
                            </TableHead>
                            <TableHead>Tanggal</TableHead>
                            <TableHead class="text-right w-[100px]">Aksi</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="newsList.data.length > 0">
                            <TableRow v-for="news in newsList.data" :key="news.id">
                                <TableCell>
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                            <Newspaper class="h-5 w-5 text-blue-600" />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-medium truncate max-w-[250px]">{{ news.title }}</p>
                                                <div class="flex items-center gap-1">
                                                    <button type="button" @click="toggleStatus(news, 'is_headline')"
                                                        class="p-0.5 rounded hover:bg-yellow-100 transition-colors"
                                                        :title="news.is_headline ? 'Hapus dari Headline' : 'Jadikan Headline'">
                                                        <Star class="h-4 w-4 cursor-pointer transition-colors"
                                                            :class="news.is_headline ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300 hover:text-yellow-400'" />
                                                    </button>
                                                    <button type="button" @click="toggleStatus(news, 'is_trending')"
                                                        class="p-0.5 rounded hover:bg-orange-100 transition-colors"
                                                        :title="news.is_trending ? 'Hapus dari Trending' : 'Jadikan Trending'">
                                                        <Flame class="h-4 w-4 cursor-pointer transition-colors"
                                                            :class="news.is_trending ? 'text-orange-500 fill-orange-500' : 'text-gray-300 hover:text-orange-500'" />
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-xs text-muted-foreground">
                                                {{ news.author?.name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline">{{ news.category }}</Badge>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" :class="getStatusBadge(news.status).class">
                                        {{ getStatusBadge(news.status).label }}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <span class="text-sm font-medium">{{ formatViews(news.views_count) }}</span>
                                </TableCell>
                                <TableCell>
                                    <span class="text-sm text-muted-foreground">
                                        {{ formatDate(news.published_at ?? news.created_at) }}
                                    </span>
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
                                                <Link :href="`/admin/news/${news.id}/edit`" class="flex items-center">
                                                    <Edit class="mr-2 h-4 w-4" />
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem as-child>
                                                <a :href="`/berita/${news.slug}`" target="_blank"
                                                    class="flex items-center">
                                                    <Eye class="mr-2 h-4 w-4" />
                                                    Lihat
                                                </a>
                                            </DropdownMenuItem>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem @click="handleDelete(news)" class="text-destructive">
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
                                        <Newspaper class="h-10 w-10 mb-2 opacity-50" />
                                        <p class="font-medium">Tidak ada berita ditemukan</p>
                                        <p class="text-sm">Coba ubah filter atau tulis berita baru</p>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </CardContent>

            <!-- Pagination -->
            <div v-if="newsList.last_page > 1" class="border-t px-4 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted-foreground">
                        Menampilkan {{ newsList.from ?? 0 }} - {{ newsList.to ?? 0 }} dari {{ newsList.total }} data
                    </p>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm" :disabled="newsList.current_page === 1"
                            @click="goToPage(newsList.links[0]?.url)">
                            <ChevronLeft class="h-4 w-4" />
                            Sebelumnya
                        </Button>

                        <div class="hidden sm:flex items-center gap-1">
                            <template v-for="(link, index) in newsList.links.slice(1, -1)" :key="index">
                                <Button v-if="link.url" variant="outline" size="sm"
                                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                                    @click="goToPage(link.url)">
                                    {{ link.label }}
                                </Button>
                                <span v-else class="px-2 text-muted-foreground">...</span>
                            </template>
                        </div>

                        <span class="sm:hidden text-sm text-muted-foreground">
                            {{ newsList.current_page }} / {{ newsList.last_page }}
                        </span>

                        <Button variant="outline" size="sm" :disabled="newsList.current_page === newsList.last_page"
                            @click="goToPage(newsList.links[newsList.links.length - 1]?.url)">
                            Selanjutnya
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>
