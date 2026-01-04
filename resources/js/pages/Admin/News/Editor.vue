<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import TiptapEditor from '@/components/ui/tiptap-editor/TiptapEditor.vue';
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
    image_url: string | null;
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
    image: null as File | null,
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
const imagePreview = ref<string | null>(props.news?.image_url ?? null);
const fileInputRef = ref<HTMLInputElement | null>(null);
const isDragging = ref(false);

const handleImageSelect = () => {
    fileInputRef.value?.click();
};

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        processImageFile(file);
    }
};

const processImageFile = (file: File) => {
    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!validTypes.includes(file.type)) {
        alert('Format file tidak didukung. Gunakan JPG, PNG, WEBP, atau GIF.');
        return;
    }

    // Validate file size (5MB max)
    const maxSize = 5 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('Ukuran file terlalu besar. Maksimal 5MB.');
        return;
    }

    // Create preview URL
    if (imagePreview.value && imagePreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(imagePreview.value);
    }
    imagePreview.value = URL.createObjectURL(file);
    form.image = file; // Store actual File object for upload
};

// Drag and drop handlers
const handleDragEnter = (event: DragEvent) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = (event: DragEvent) => {
    event.preventDefault();
    isDragging.value = false;
};

const handleDragOver = (event: DragEvent) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDrop = (event: DragEvent) => {
    event.preventDefault();
    isDragging.value = false;

    const files = event.dataTransfer?.files;
    if (files && files.length > 0) {
        processImageFile(files[0]);
    }
};

const removeImage = () => {
    if (imagePreview.value && imagePreview.value.startsWith('blob:')) {
        URL.revokeObjectURL(imagePreview.value);
    }
    imagePreview.value = null;
    form.image = null;
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
    // Clear any previous errors
    form.clearErrors();

    if (publish) {
        form.is_published = true;
        form.published_at = new Date().toISOString();
    }

    const options = {
        preserveScroll: true,
        forceFormData: true, // Force multipart/form-data for file upload
        onError: (errors: Record<string, string>) => {
            console.error('Form submission errors:', errors);
        },
    };

    if (props.isEditing && props.news?.id) {
        // Use transform to add _method for PUT spoofing with file uploads
        // Also explicitly convert boolean values to "1" or "0" for FormData
        form.transform((data) => ({
            ...data,
            is_headline: data.is_headline ? '1' : '0',
            is_trending: data.is_trending ? '1' : '0',
            is_published: data.is_published ? '1' : '0',
            _method: 'PUT',
        })).post(`/admin/news/${props.news.id}`, options);
    } else {
        // Explicitly convert boolean values to "1" or "0" for FormData
        form.transform((data) => ({
            ...data,
            is_headline: data.is_headline ? '1' : '0',
            is_trending: data.is_trending ? '1' : '0',
            is_published: data.is_published ? '1' : '0',
        })).post('/admin/news', options);
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
                            <TiptapEditor v-model="form.content" placeholder="Tulis isi berita lengkap di sini..."
                                min-height="400px" :class="{ 'ring-2 ring-destructive': form.errors.content }"
                                @update:modelValue="(val: string) => form.content = val" />
                            <p class="text-xs text-muted-foreground">
                                Gunakan toolbar di atas untuk formatting. Konten akan disimpan sebagai HTML.
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
                        <input ref="fileInputRef" type="file" accept="image/jpeg,image/png,image/webp,image/gif"
                            class="hidden" @change="handleImageChange" />

                        <!-- Image Preview -->
                        <div v-if="imagePreview" class="space-y-4">
                            <div class="relative group rounded-lg overflow-hidden border bg-muted">
                                <img :src="imagePreview" alt="Preview"
                                    class="w-full h-64 object-cover transition-transform group-hover:scale-105" />
                                <!-- Overlay on hover -->
                                <div
                                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <Button variant="secondary" size="sm" @click="handleImageSelect">
                                        <ImagePlus class="mr-2 h-4 w-4" />
                                        Ganti Gambar
                                    </Button>
                                    <Button variant="destructive" size="sm" @click="removeImage">
                                        <Trash2 class="mr-2 h-4 w-4" />
                                        Hapus
                                    </Button>
                                </div>
                            </div>
                            <!-- Image info bar -->
                            <div
                                class="flex items-center justify-between rounded-lg border bg-muted/50 px-4 py-2 text-sm">
                                <div class="flex items-center gap-2 text-muted-foreground">
                                    <ImagePlus class="h-4 w-4" />
                                    <span class="truncate max-w-[200px]">{{ form.image || 'gambar-berita.jpg' }}</span>
                                </div>
                                <Button variant="ghost" size="sm" class="h-7 text-destructive hover:text-destructive"
                                    @click="removeImage">
                                    <X class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>

                        <!-- Drag and Drop Zone -->
                        <div v-else @click="handleImageSelect" @dragenter="handleDragEnter" @dragleave="handleDragLeave"
                            @dragover="handleDragOver" @drop="handleDrop" :class="[
                                'relative border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-all duration-200',
                                isDragging
                                    ? 'border-primary bg-primary/5 scale-[1.02]'
                                    : 'border-muted-foreground/25 hover:border-primary/50 hover:bg-muted/50'
                            ]">
                            <!-- Animated background pattern when dragging -->
                            <div v-if="isDragging"
                                class="absolute inset-0 bg-gradient-to-r from-primary/5 via-primary/10 to-primary/5 animate-pulse rounded-lg" />

                            <div class="relative z-10 space-y-4">
                                <!-- Icon -->
                                <div :class="[
                                    'mx-auto w-16 h-16 rounded-full flex items-center justify-center transition-colors',
                                    isDragging ? 'bg-primary/20' : 'bg-muted'
                                ]">
                                    <ImagePlus :class="[
                                        'h-8 w-8 transition-colors',
                                        isDragging ? 'text-primary' : 'text-muted-foreground'
                                    ]" />
                                </div>

                                <!-- Text -->
                                <div>
                                    <p :class="[
                                        'font-medium transition-colors',
                                        isDragging ? 'text-primary' : 'text-foreground'
                                    ]">
                                        {{ isDragging ? 'Lepaskan gambar di sini' : 'Drag & drop gambar di sini' }}
                                    </p>
                                    <p class="text-sm text-muted-foreground mt-1">
                                        atau <span class="text-primary font-medium hover:underline">pilih file</span>
                                        dari komputer
                                    </p>
                                </div>

                                <!-- Supported formats -->
                                <div class="flex items-center justify-center gap-2 text-xs text-muted-foreground">
                                    <span class="px-2 py-1 rounded bg-muted">JPG</span>
                                    <span class="px-2 py-1 rounded bg-muted">PNG</span>
                                    <span class="px-2 py-1 rounded bg-muted">WEBP</span>
                                    <span class="px-2 py-1 rounded bg-muted">GIF</span>
                                    <span class="text-muted-foreground/70">• Max 5MB</span>
                                </div>
                            </div>
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
