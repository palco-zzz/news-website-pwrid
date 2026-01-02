<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
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
import { Separator } from '@/components/ui/separator';
import { Textarea } from '@/components/ui/textarea';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ImagePlus,
    Loader2,
    MapPin,
    Phone,
    Save,
    Store,
    Trash2,
    X,
} from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories?: string[];
}>();

// Default categories
const defaultCategories = ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Lainnya'];
const availableCategories = computed(() => props.categories ?? defaultCategories);

// Form state
const form = useForm({
    name: '',
    description: '',
    image: null as File | null,
    category: 'Kuliner',
    address: '',
    phone: '',
    whatsapp: '',
    instagram: '',
    latitude: '' as string | number,
    longitude: '' as string | number,
});

// Image upload
const imagePreview = ref<string | null>(null);
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
    form.image = file;
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

// Form submission
const submitForm = () => {
    form.post('/admin/umkm', {
        preserveScroll: true,
        forceFormData: true,
    });
};
</script>

<template>

    <Head title="Tambah UMKM" />

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link href="/admin/umkm">
                        <ArrowLeft class="h-5 w-5" />
                    </Link>
                </Button>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Tambah UMKM Baru</h1>
                    <p class="text-muted-foreground">
                        Daftarkan UMKM baru ke dalam portal
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="outline" as-child>
                    <Link href="/admin/umkm">
                        Batal
                    </Link>
                </Button>
                <Button @click="submitForm" :disabled="form.processing">
                    <template v-if="form.processing">
                        <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                        Menyimpan...
                    </template>
                    <template v-else>
                        <Save class="mr-2 h-4 w-4" />
                        Simpan UMKM
                    </template>
                </Button>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Main Content (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Store class="h-5 w-5" />
                            Informasi UMKM
                        </CardTitle>
                        <CardDescription>
                            Isi informasi dasar tentang UMKM
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <Label for="name">Nama UMKM <span class="text-destructive">*</span></Label>
                            <Input id="name" v-model="form.name" placeholder="Contoh: Warung Makan Bu Siti"
                                :class="{ 'border-destructive': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-sm text-destructive">
                                {{ form.errors.name }}
                            </p>
                        </div>

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

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Deskripsi</Label>
                            <Textarea id="description" v-model="form.description"
                                placeholder="Jelaskan tentang UMKM ini, produk/layanan yang ditawarkan..." :rows="5"
                                :class="{ 'border-destructive': form.errors.description }" />
                            <p v-if="form.errors.description" class="text-sm text-destructive">
                                {{ form.errors.description }}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <!-- Featured Image Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <ImagePlus class="h-5 w-5" />
                            Gambar UMKM
                        </CardTitle>
                        <CardDescription>
                            Upload gambar yang merepresentasikan UMKM
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
                                    <span class="truncate max-w-[200px]">{{ form.image?.name || 'gambar-umkm.jpg'
                                    }}</span>
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

            <!-- Sidebar (Right - 1 column) -->
            <div class="space-y-6">
                <!-- Location Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <MapPin class="h-5 w-5" />
                            Lokasi
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <!-- Address -->
                        <div class="space-y-2">
                            <Label for="address">Alamat Lengkap</Label>
                            <Textarea id="address" v-model="form.address"
                                placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota" :rows="3"
                                :class="{ 'border-destructive': form.errors.address }" />
                            <p v-if="form.errors.address" class="text-sm text-destructive">
                                {{ form.errors.address }}
                            </p>
                        </div>

                        <Separator />

                        <!-- Coordinates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="latitude">Latitude</Label>
                                <Input id="latitude" v-model="form.latitude" type="number" step="any"
                                    placeholder="-6.123456" :class="{ 'border-destructive': form.errors.latitude }" />
                            </div>
                            <div class="space-y-2">
                                <Label for="longitude">Longitude</Label>
                                <Input id="longitude" v-model="form.longitude" type="number" step="any"
                                    placeholder="106.123456" :class="{ 'border-destructive': form.errors.longitude }" />
                            </div>
                        </div>
                        <p class="text-xs text-muted-foreground">
                            Koordinat GPS untuk menampilkan lokasi di peta
                        </p>
                    </CardContent>
                </Card>

                <!-- Contact Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Phone class="h-5 w-5" />
                            Kontak
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <!-- Phone -->
                        <div class="space-y-2">
                            <Label for="phone">Nomor Telepon</Label>
                            <Input id="phone" v-model="form.phone" type="tel" placeholder="08123456789"
                                :class="{ 'border-destructive': form.errors.phone }" />
                            <p v-if="form.errors.phone" class="text-sm text-destructive">
                                {{ form.errors.phone }}
                            </p>
                        </div>

                        <!-- WhatsApp -->
                        <div class="space-y-2">
                            <Label for="whatsapp">WhatsApp</Label>
                            <Input id="whatsapp" v-model="form.whatsapp" type="tel" placeholder="08123456789"
                                :class="{ 'border-destructive': form.errors.whatsapp }" />
                            <p v-if="form.errors.whatsapp" class="text-sm text-destructive">
                                {{ form.errors.whatsapp }}
                            </p>
                        </div>

                        <!-- Instagram -->
                        <div class="space-y-2">
                            <Label for="instagram">Instagram</Label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-sm">@</span>
                                <Input id="instagram" v-model="form.instagram" class="pl-8" placeholder="username_ig"
                                    :class="{ 'border-destructive': form.errors.instagram }" />
                            </div>
                            <p v-if="form.errors.instagram" class="text-sm text-destructive">
                                {{ form.errors.instagram }}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <!-- Quick Actions -->
                <Card>
                    <CardContent class="pt-6 space-y-2">
                        <Button class="w-full justify-start" @click="submitForm" :disabled="form.processing">
                            <Save class="mr-2 h-4 w-4" />
                            Simpan UMKM
                        </Button>
                        <Button variant="outline" class="w-full justify-start" as-child>
                            <Link href="/admin/umkm">
                                <ArrowLeft class="mr-2 h-4 w-4" />
                                Kembali ke Daftar
                            </Link>
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
