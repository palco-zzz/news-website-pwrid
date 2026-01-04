<template>

    <Head title="Info Warga" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-950 tracking-tighter uppercase">Info <span
                            class="text-indigo-600">Warga</span></h2>
                </div>
                <p class="text-slate-500 font-bold text-sm">Kabar tercepat dari setiap sudut Kabupaten Purworejo.</p>
            </div>

            <Dialog v-model:open="isDialogOpen">
                <DialogTrigger as-child>
                    <button
                        class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:scale-95 transition-transform flex items-center gap-3">
                        <i class="fa-solid fa-camera"></i> Kirim Info/Laporan
                    </button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[600px] max-h-[90vh] overflow-y-auto">
                    <DialogHeader>
                        <DialogTitle>Buat Laporan Warga</DialogTitle>
                        <DialogDescription>
                            Sampaikan informasi atau laporan kejadian di sekitarmu.
                        </DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="submit" class="space-y-6 mt-4">
                        <!-- Judul -->
                        <div class="space-y-2">
                            <Label for="title">Judul Laporan</Label>
                            <Input id="title" v-model="form.title"
                                placeholder="Contoh: Pohon Tumbang di Jalan Kartini" />
                            <p v-if="form.errors.title" class="text-sm text-red-500 font-medium">{{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Kategori & Lokasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="category">Kategori</Label>
                                <Select v-model="form.category">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Pilih Kategori" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="Umum">Umum</SelectItem>
                                        <SelectItem value="Infrastruktur">Infrastruktur</SelectItem>
                                        <SelectItem value="Keamanan">Keamanan</SelectItem>
                                        <SelectItem value="Kesehatan">Kesehatan</SelectItem>
                                        <SelectItem value="Lingkungan">Lingkungan</SelectItem>
                                        <SelectItem value="Sosial">Sosial</SelectItem>
                                        <SelectItem value="Lalulintas">Lalulintas</SelectItem>
                                        <SelectItem value="Bencana">Bencana</SelectItem>
                                    </SelectContent>
                                </Select>
                                <p v-if="form.errors.category" class="text-sm text-red-500 font-medium">{{
                                    form.errors.category }}</p>
                            </div>

                            <div class="space-y-2">
                                <Label for="location">Lokasi Kejadian</Label>
                                <Input id="location" v-model="form.location"
                                    placeholder="Nama Jalan / Desa / Kecamatan" />
                                <p v-if="form.errors.location" class="text-sm text-red-500 font-medium">{{
                                    form.errors.location }}</p>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-2">
                            <Label for="content">Deskripsi Lengkap</Label>
                            <Textarea id="content" v-model="form.content" placeholder="Ceritakan detail kejadian..."
                                class="min-h-[120px]" />
                            <p v-if="form.errors.content" class="text-sm text-red-500 font-medium">{{
                                form.errors.content }}</p>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="space-y-2">
                            <Label>Foto Kejadian (Opsional)</Label>
                            <div
                                class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:bg-slate-50 transition-colors cursor-pointer relative">
                                <input type="file" @change="handleImageUpload"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" />
                                <div v-if="imagePreview" class="relative">
                                    <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg shadow-sm" />
                                    <button type="button" @click.stop="removeImage"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600">
                                        <X class="w-4 h-4" />
                                    </button>
                                </div>
                                <div v-else class="flex flex-col items-center gap-2 text-slate-500">
                                    <Camera class="w-8 h-8 text-slate-300" />
                                    <span class="text-sm font-medium">Klik untuk upload foto</span>
                                    <span class="text-xs text-slate-400">Max 10MB (JPG, PNG)</span>
                                </div>
                            </div>
                            <p v-if="form.errors.image" class="text-sm text-red-500 font-medium">{{ form.errors.image }}
                            </p>
                        </div>

                        <!-- Opsi Tambahan -->
                        <div class="flex items-center space-x-2">
                            <Checkbox id="anonymous" :checked="form.is_anonymous"
                                @update:checked="val => form.is_anonymous = val" />
                            <label for="anonymous"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Kirim sebagai anonim (nama disembunyikan)
                            </label>
                        </div>

                        <DialogFooter>
                            <Button type="submit" class="w-full" :disabled="form.processing">
                                <span v-if="form.processing">Mengirim...</span>
                                <span v-else>Kirim Laporan</span>
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>

        <!-- Categories -->
        <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
            <button v-for="category in categories" :key="category"
                class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">
                {{ category }}
            </button>
        </div>

        <!-- Empty State -->
        <EmptyState v-if="!reports.data.length" title="Belum Ada Laporan"
            description="Jadilah warga yang aktif! Laporkan kejadian di sekitarmu agar warga lain tahu."
            :lucide-icon="Megaphone" action-label="Buat Laporan" :show-action-for-all="true" @action="createReport" />

        <div v-else>
            <!-- Popular Reports -->
            <div v-if="popularReports.length > 0"
                class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-6 border border-indigo-100 mb-8">
                <h2 class="text-sm font-black text-indigo-600 uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-arrow-trend-up mr-2"></i>Paling Banyak Didukung
                </h2>
                <div class="space-y-3">
                    <Link v-for="report in popularReports" :key="report.id" :href="`/laporan-warga/${report.slug}`"
                        class="flex items-center gap-4 p-3 bg-white/60 rounded-xl hover:bg-white transition-colors cursor-pointer">
                        <div class="flex items-center gap-1 text-indigo-600">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span class="font-bold text-sm">{{ report.upvotes_count }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">{{ report.title }}</h3>
                            <span class="text-xs text-slate-400">{{ report.location }}</span>
                        </div>
                        <StatusBadge :status="report.status" />
                    </Link>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Link v-for="report in reports.data" :key="report.id" :href="`/laporan-warga/${report.slug}`"
                    class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-all hover:-translate-y-1 cursor-pointer block">
                    <div v-if="report.image" class="aspect-video bg-slate-100 overflow-hidden">
                        <img :src="getImageUrl(report.image)" :alt="report.title" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-indigo-600 uppercase">{{ report.category }}</span>
                            <StatusBadge :status="report.status" />
                        </div>
                        <h3 class="font-bold text-slate-900 line-clamp-2">{{ report.title }}</h3>
                        <p v-if="report.location" class="text-sm text-slate-500 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                            {{ report.location }}
                        </p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                            <span class="text-xs text-slate-400">
                                {{ report.is_anonymous ? 'Anonim' : report.reporter_name }}
                            </span>
                            <span class="text-xs font-bold text-indigo-600">
                                <i class="fa-solid fa-arrow-up mr-1"></i>{{ report.upvotes_count }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Megaphone, Camera, X } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
import EmptyState from '@/components/EmptyState.vue';
import StatusBadge from '@/components/StatusBadge.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { ref } from 'vue';

// Helper function to get proper image URL
const getImageUrl = (imagePath) => {
    if (!imagePath) return null;
    if (imagePath.startsWith('http')) return imagePath;
    return `/storage/${imagePath}`;
};


defineOptions({ layout: MainLayout });

const props = defineProps({
    reports: {
        type: Object,
        default: () => ({ data: [] }),
    },
    popularReports: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => ['Semua', 'Kehilangan', 'Infrastruktur', 'Kecelakaan', 'Aspirasi'],
    }
});

const form = useForm({
    title: '',
    category: '',
    location: '',
    content: '',
    image: null,
    is_anonymous: false
});

const imagePreview = ref(null);
const isDialogOpen = ref(false);

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = null;
};

const submit = () => {
    form.post('/laporan-warga', {
        onSuccess: () => {
            form.reset();
            removeImage();
            isDialogOpen.value = false;
            alert('Laporan berhasil dikirim! Menunggu verifikasi.');
        },
    });
};

const createReport = () => {
    isDialogOpen.value = true;
};
</script>
