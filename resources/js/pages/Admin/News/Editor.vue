<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import { Textarea } from '@/components/ui/textarea';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Calendar,
    Eye,
    FileText,
    ImagePlus,
    Loader2,
    Save,
    Send,
    Tag,
    Trash2,
    X,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

interface News {
    id?: number;
    title: string;
    slug: string;
    excerpt: string;
    content: string;
    image: string | null;
    category: string;
    is_headline: boolean;
    is_trending: boolean;
    is_published: boolean;
    published_at: string | null;
}

const props = defineProps<{
    news?: News;
    categories?: string[];
    isEditing?: boolean;
}>();

// Default categories
const defaultCategories = ['Berita', 'Politik', 'Ekonomi', 'Olahraga', 'Hiburan', 'Teknologi', 'Kesehatan', 'Pendidikan'];
const availableCategories = computed(() => props.categories ?? defaultCategories);

// Form state
const form = useForm({
    title: props.news?.title ?? '',
    slug: props.news?.slug ?? '',
    excerpt: props.news?.excerpt ?? '',
    content: props.news?.content ?? '',
    image: props.news?.image ?? '',
    category: props.news?.category ?? 'Berita',
    is_headline: props.news?.is_headline ?? false,
    is_trending: props.news?.is_trending ?? false,
    is_published: props.news?.is_published ?? false,
    published_at: props.news?.published_at ?? '',
});

// Tags input
const tagsInput = ref('');
const tags = ref<string[]>([]);

// Auto-generate slug from title
const generateSlug = (title: string) => {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
};

watch(() => form.title, (newTitle) => {
    if (!props.isEditing || !form.slug) {
        form.slug = generateSlug(newTitle);
    }
});

// Image upload placeholder
const imagePreview = ref<string | null>(props.news?.image ?? null);
const fileInputRef = ref<HTMLInputElement | null>(null);

const handleImageSelect = () => {
    fileInputRef.value?.click();
};

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        // For now, just create a preview URL
        // In production, you would upload to server/storage
        imagePreview.value = URL.createObjectURL(file);
        form.image = file.name; // Placeholder - actual upload logic needed
    }
};

const removeImage = () => {
    imagePreview.value = null;
    form.image = '';
    if (fileInputRef.value) {
        fileInputRef.value.value = '';
    }
};

// Add tag
const addTag = () => {
    const tag = tagsInput.value.trim();
    if (tag && !tags.value.includes(tag)) {
        tags.value.push(tag);
        tagsInput.value = '';
    }
};

const removeTag = (index: number) => {
    tags.value.splice(index, 1);
};

// Form submission
const submitForm = (publish: boolean = false) => {
    if (publish) {
        form.is_published = true;
        form.published_at = new Date().toISOString();
    }

    if (props.isEditing && props.news?.id) {
        form.put(`/admin/news/${props.news.id}`, {
            preserveScroll: true,
        });
    } else {
        form.post('/admin/news', {
            preserveScroll: true,
        });
    }
};

// Save as draft
const saveDraft = () => {
    form.is_published = false;
    submitForm(false);
};

// Publish
const publish = () => {
    submitForm(true);
};

// Preview (placeholder)
const preview = () => {
    // Open preview in new tab
    window.open(`/berita/${form.slug}?preview=true`, '_blank');
};

// Page title
const pageTitle = computed(() => props.isEditing ? 'Edit Berita' : 'Tulis Berita Baru');
</script>

<template>

    <Head :title="pageTitle" />

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link href="/admin/news">
                        <ArrowLeft class="h-5 w-5" />
                    </Link>
                </Button>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">{{ pageTitle }}</h1>
                    <p class="text-muted-foreground">
                        {{ isEditing ? 'Perbarui artikel berita' : 'Buat artikel berita baru untuk portal' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="outline" @click="preview" :disabled="!form.slug">
                    <Eye class="mr-2 h-4 w-4" />
                    Preview
                </Button>
                <Button variant="outline" @click="saveDraft" :disabled="form.processing">
                    <Save class="mr-2 h-4 w-4" />
                    Simpan Draft
                </Button>
                <Button @click="publish" :disabled="form.processing">
                    <template v-if="form.processing">
                        <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                        Menyimpan...
                    </template>
                    <template v-else>
                        <Send class="mr-2 h-4 w-4" />
                        Publish
                    </template>
                </Button>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Main Content (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Content Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <FileText class="h-5 w-5" />
                            Konten Berita
                        </CardTitle>
                        <CardDescription>
                            Tulis judul dan isi berita Anda
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <!-- Title -->
                        <div class="space-y-2">
                            <Label for="title">Judul Berita <span class="text-destructive">*</span></Label>
                            <Input id="title" v-model="form.title" placeholder="Masukkan judul berita yang menarik..."
                                class="text-lg" :class="{ 'border-destructive': form.errors.title }" />
                            <p v-if="form.errors.title" class="text-sm text-destructive">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Slug -->
                        <div class="space-y-2">
                            <Label for="slug">URL Slug</Label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-muted-foreground">/berita/</span>
                                <Input id="slug" v-model="form.slug" placeholder="url-slug-berita"
                                    class="font-mono text-sm" :class="{ 'border-destructive': form.errors.slug }" />
                            </div>
                            <p v-if="form.errors.slug" class="text-sm text-destructive">
                                {{ form.errors.slug }}
                            </p>
                        </div>

                        <!-- Excerpt -->
                        <div class="space-y-2">
                            <Label for="excerpt">Ringkasan / Excerpt</Label>
                            <Textarea id="excerpt" v-model="form.excerpt"
                                placeholder="Tulis ringkasan singkat berita (akan ditampilkan di preview)..." :rows="3"
                                :class="{ 'border-destructive': form.errors.excerpt }" />
                            <p class="text-xs text-muted-foreground">
                                Maksimal 200 karakter. {{ form.excerpt.length }}/200
                            </p>
                            <p v-if="form.errors.excerpt" class="text-sm text-destructive">
                                {{ form.errors.excerpt }}
                            </p>
                        </div>

                        <!-- Content Body -->
                        <div class="space-y-2">
                            <Label for="content">Isi Berita <span class="text-destructive">*</span></Label>
                            <Textarea id="content" v-model="form.content"
                                placeholder="Tulis isi berita lengkap di sini..." :rows="15" class="font-serif"
                                :class="{ 'border-destructive': form.errors.content }" />
                            <p class="text-xs text-muted-foreground">
                                Mendukung format HTML dasar untuk styling
                            </p>
                            <p v-if="form.errors.content" class="text-sm text-destructive">
                                {{ form.errors.content }}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <!-- Featured Image Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <ImagePlus class="h-5 w-5" />
                            Gambar Utama
                        </CardTitle>
                        <CardDescription>
                            Upload gambar yang akan ditampilkan sebagai thumbnail
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <input ref="fileInputRef" type="file" accept="image/*" class="hidden"
                            @change="handleImageChange" />

                        <div v-if="imagePreview" class="relative">
                            <img :src="imagePreview" alt="Preview" class="w-full h-64 object-cover rounded-lg" />
                            <Button variant="destructive" size="icon" class="absolute top-2 right-2"
                                @click="removeImage">
                                <Trash2 class="h-4 w-4" />
                            </Button>
                        </div>

                        <div v-else @click="handleImageSelect"
                            class="border-2 border-dashed border-muted-foreground/25 rounded-lg p-12 text-center cursor-pointer hover:border-muted-foreground/50 transition-colors">
                            <ImagePlus class="h-12 w-12 mx-auto text-muted-foreground/50 mb-4" />
                            <p class="text-sm font-medium text-muted-foreground">
                                Klik untuk upload gambar
                            </p>
                            <p class="text-xs text-muted-foreground mt-1">
                                PNG, JPG, WEBP hingga 5MB
                            </p>
                        </div>

                        <p v-if="form.errors.image" class="text-sm text-destructive mt-2">
                            {{ form.errors.image }}
                        </p>
                    </CardContent>
                </Card>
            </div>

            <!-- Metadata Sidebar (Right - 1 column) -->
            <div class="space-y-6">
                <!-- Category & Status Card -->
                <Card>
                    <CardHeader>
                        <CardTitle>Kategori & Status</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <!-- Category -->
                        <div class="space-y-2">
                            <Label>Kategori <span class="text-destructive">*</span></Label>
                            <Select v-model="form.category">
                                <SelectTrigger :class="{ 'border-destructive': form.errors.category }">
                                    <SelectValue placeholder="Pilih kategori" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in availableCategories" :key="category"
                                        :value="category">
                                        {{ category }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.category" class="text-sm text-destructive">
                                {{ form.errors.category }}
                            </p>
                        </div>

                        <Separator />

                        <!-- Headline Toggle -->
                        <div class="flex items-center justify-between">
                            <div class="space-y-0.5">
                                <Label>Jadikan Headline</Label>
                                <p class="text-xs text-muted-foreground">
                                    Tampilkan di bagian utama beranda
                                </p>
                            </div>
                            <Checkbox :checked="form.is_headline" @update:checked="form.is_headline = $event" />
                        </div>

                        <!-- Trending Toggle -->
                        <div class="flex items-center justify-between">
                            <div class="space-y-0.5">
                                <Label>Tandai Trending</Label>
                                <p class="text-xs text-muted-foreground">
                                    Tampilkan di halaman trending
                                </p>
                            </div>
                            <Checkbox :checked="form.is_trending" @update:checked="form.is_trending = $event" />
                        </div>
                    </CardContent>
                </Card>

                <!-- Tags Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Tag class="h-4 w-4" />
                            Tags
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex gap-2">
                            <Input v-model="tagsInput" placeholder="Tambah tag..." @keyup.enter="addTag" />
                            <Button variant="outline" size="icon" @click="addTag">
                                <Tag class="h-4 w-4" />
                            </Button>
                        </div>

                        <div v-if="tags.length > 0" class="flex flex-wrap gap-2">
                            <Badge v-for="(tag, index) in tags" :key="index" variant="secondary" class="gap-1">
                                {{ tag }}
                                <button @click="removeTag(index)" class="ml-1 hover:text-destructive">
                                    <X class="h-3 w-3" />
                                </button>
                            </Badge>
                        </div>

                        <p v-else class="text-sm text-muted-foreground">
                            Belum ada tags. Tekan Enter untuk menambah tag.
                        </p>
                    </CardContent>
                </Card>

                <!-- Publish Date Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Calendar class="h-4 w-4" />
                            Jadwal Publikasi
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="published_at">Tanggal & Waktu Publish</Label>
                            <Input id="published_at" type="datetime-local" v-model="form.published_at" />
                            <p class="text-xs text-muted-foreground">
                                Kosongkan untuk publish sekarang
                            </p>
                        </div>

                        <div class="rounded-lg bg-muted p-3">
                            <p class="text-sm font-medium">Status Saat Ini</p>
                            <div class="flex items-center gap-2 mt-1">
                                <Badge :variant="form.is_published ? 'default' : 'secondary'">
                                    {{ form.is_published ? 'Published' : 'Draft' }}
                                </Badge>
                                <span v-if="news?.published_at" class="text-xs text-muted-foreground">
                                    {{ new Date(news.published_at).toLocaleDateString('id-ID') }}
                                </span>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Quick Actions -->
                <Card>
                    <CardContent class="pt-6 space-y-2">
                        <Button variant="outline" class="w-full justify-start" @click="saveDraft">
                            <Save class="mr-2 h-4 w-4" />
                            Simpan sebagai Draft
                        </Button>
                        <Button class="w-full justify-start" @click="publish">
                            <Send class="mr-2 h-4 w-4" />
                            Publish Sekarang
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
