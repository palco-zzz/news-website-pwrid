<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import UserInfo from '@/components/UserInfo.vue';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarProvider,
    SidebarTrigger,
    useSidebar,
} from '@/components/ui/sidebar';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { getInitials } from '@/composables/useInitials';
import { urlIsActive } from '@/lib/utils';
import admin from '@/routes/admin';
import type { BreadcrumbItem, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    Bell,
    Calendar,
    ChevronsUpDown,
    FileText,
    Home,
    LogOut,
    Menu,
    Megaphone,
    Search,
    Settings,
    Store,
    Users,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isOpen = page.props.sidebarOpen;

const searchQuery = ref('');

// Main navigation items
const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: admin.dashboard().url,
        icon: Home,
    },
    {
        title: 'Berita',
        href: admin.news.index().url,
        icon: FileText,
    },
    {
        title: 'UMKM',
        href: admin.umkm.index().url,
        icon: Store,
    },
    {
        title: 'Info Warga',
        href: admin.citizenReports.index().url,
        icon: Megaphone,
    },
    {
        title: 'Agenda',
        href: admin.agenda.index().url,
        icon: Calendar,
    },
];

const settingsNavItems: NavItem[] = [
    {
        title: 'Settings',
        href: admin.settings.index().url,
        icon: Settings,
    },
];
</script>

<template>
    <SidebarProvider :default-open="isOpen ?? true">
        <div class="flex min-h-screen w-full">
            <!-- Desktop Sidebar -->
            <Sidebar collapsible="icon" class="border-r border-sidebar-border">
                <SidebarHeader class="border-b border-sidebar-border/50">
                    <SidebarMenu>
                        <SidebarMenuItem>
                            <SidebarMenuButton size="lg" as-child>
                                <Link :href="admin.dashboard().url" class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold shadow-md">
                                        P
                                    </div>
                                    <div class="flex flex-col leading-none group-data-[collapsible=icon]:hidden">
                                        <span class="font-bold text-base tracking-tight">
                                            Purworejonya<span class="text-indigo-600">.id</span>
                                        </span>
                                        <span class="text-[10px] text-muted-foreground uppercase tracking-wider">
                                            Admin Panel
                                        </span>
                                    </div>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarHeader>

                <SidebarContent class="py-2">
                    <!-- Main Navigation -->
                    <SidebarGroup>
                        <SidebarGroupLabel class="text-xs uppercase tracking-wider text-muted-foreground/70">
                            Menu Utama
                        </SidebarGroupLabel>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in mainNavItems" :key="item.title">
                                <SidebarMenuButton as-child :is-active="urlIsActive(item.href, page.url)"
                                    :tooltip="item.title">
                                    <Link :href="item.href">
                                        <component :is="item.icon" class="h-4 w-4" />
                                        <span>{{ item.title }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroup>

                    <Separator class="my-2" />

                    <!-- Settings Navigation -->
                    <SidebarGroup>
                        <SidebarGroupLabel class="text-xs uppercase tracking-wider text-muted-foreground/70">
                            Pengaturan
                        </SidebarGroupLabel>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in settingsNavItems" :key="item.title">
                                <SidebarMenuButton as-child :is-active="urlIsActive(item.href, page.url)"
                                    :tooltip="item.title">
                                    <Link :href="item.href">
                                        <component :is="item.icon" class="h-4 w-4" />
                                        <span>{{ item.title }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroup>
                </SidebarContent>

                <SidebarFooter class="border-t border-sidebar-border/50">
                    <SidebarMenu>
                        <SidebarMenuItem>
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <SidebarMenuButton size="lg"
                                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarImage v-if="user?.avatar" :src="user.avatar" :alt="user?.name" />
                                            <AvatarFallback
                                                class="rounded-lg bg-indigo-100 text-indigo-700 text-xs font-medium">
                                                {{ getInitials(user?.name ?? 'Admin') }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div
                                            class="grid flex-1 text-left text-sm leading-tight group-data-[collapsible=icon]:hidden">
                                            <span class="truncate font-semibold">{{ user?.name ?? 'Admin' }}</span>
                                            <span class="truncate text-xs text-muted-foreground">{{ user?.email ?? ''
                                            }}</span>
                                        </div>
                                        <ChevronsUpDown class="ml-auto size-4 group-data-[collapsible=icon]:hidden" />
                                    </SidebarMenuButton>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent class="w-56 rounded-lg" side="right" align="end" :side-offset="4">
                                    <UserMenuContent v-if="user" :user="user" />
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarFooter>
            </Sidebar>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col">
                <!-- Header -->
                <header
                    class="sticky top-0 z-40 flex h-16 items-center gap-4 border-b border-sidebar-border/70 bg-background/95 backdrop-blur supports-backdrop-filter:bg-background/60 px-4 md:px-6">
                    <!-- Mobile Menu Trigger -->
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button variant="ghost" size="icon" class="md:hidden">
                                <Menu class="h-5 w-5" />
                                <span class="sr-only">Toggle menu</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-72 p-0">
                            <SheetHeader class="border-b border-sidebar-border/50 p-4">
                                <SheetTitle class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold shadow-md">
                                        P
                                    </div>
                                    <div class="flex flex-col leading-none">
                                        <span class="font-bold text-base tracking-tight">
                                            Purworejonya<span class="text-indigo-600">.id</span>
                                        </span>
                                        <span class="text-[10px] text-muted-foreground uppercase tracking-wider">
                                            Admin Panel
                                        </span>
                                    </div>
                                </SheetTitle>
                            </SheetHeader>
                            <nav class="flex flex-col gap-1 p-4">
                                <span
                                    class="px-2 py-1.5 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Menu Utama
                                </span>
                                <Link v-for="item in mainNavItems" :key="item.title" :href="item.href" :class="[
                                    'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                                    urlIsActive(item.href, page.url)
                                        ? 'bg-indigo-50 text-indigo-700'
                                        : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                                ]">
                                    <component :is="item.icon" class="h-4 w-4" />
                                    {{ item.title }}
                                </Link>
                                <Separator class="my-2" />
                                <span
                                    class="px-2 py-1.5 text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Pengaturan
                                </span>
                                <Link v-for="item in settingsNavItems" :key="item.title" :href="item.href" :class="[
                                    'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                                    urlIsActive(item.href, page.url)
                                        ? 'bg-indigo-50 text-indigo-700'
                                        : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                                ]">
                                    <component :is="item.icon" class="h-4 w-4" />
                                    {{ item.title }}
                                </Link>
                            </nav>
                        </SheetContent>
                    </Sheet>

                    <!-- Desktop Sidebar Toggle -->
                    <SidebarTrigger class="hidden md:flex -ml-1" />

                    <!-- Breadcrumbs -->
                    <div class="hidden md:flex">
                        <Breadcrumbs v-if="breadcrumbs.length > 0" :breadcrumbs="breadcrumbs" />
                    </div>

                    <div class="flex-1" />

                    <!-- Search Bar -->
                    <div class="relative hidden md:flex max-w-sm flex-1">
                        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                        <Input v-model="searchQuery" type="search" placeholder="Cari berita, UMKM, laporan..."
                            class="w-full pl-9 h-9 bg-muted/50 border-0 focus-visible:bg-background focus-visible:ring-1" />
                    </div>

                    <!-- Mobile Search -->
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button variant="ghost" size="icon" class="md:hidden">
                                    <Search class="h-5 w-5" />
                                    <span class="sr-only">Search</span>
                                </Button>
                            </TooltipTrigger>
                            <TooltipContent>Search</TooltipContent>
                        </Tooltip>
                    </TooltipProvider>

                    <!-- Notifications -->
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button variant="ghost" size="icon" class="relative">
                                    <Bell class="h-5 w-5" />
                                    <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500" />
                                    <span class="sr-only">Notifications</span>
                                </Button>
                            </TooltipTrigger>
                            <TooltipContent>Notifications</TooltipContent>
                        </Tooltip>
                    </TooltipProvider>

                    <!-- User Profile Dropdown -->
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="ghost" size="icon" class="rounded-full">
                                <Avatar class="h-8 w-8">
                                    <AvatarImage v-if="user?.avatar" :src="user.avatar" :alt="user?.name" />
                                    <AvatarFallback class="bg-indigo-100 text-indigo-700 text-xs font-medium">
                                        {{ getInitials(user?.name ?? 'Admin') }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class="w-56 rounded-lg" align="end" :side-offset="8">
                            <UserMenuContent v-if="user" :user="user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-slate-50/50">
                    <div class="p-4 md:p-6 lg:p-8">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </SidebarProvider>
</template>

<style scoped>
/* Custom scrollbar for main content */
main::-webkit-scrollbar {
    width: 6px;
}

main::-webkit-scrollbar-track {
    background: transparent;
}

main::-webkit-scrollbar-thumb {
    background-color: hsl(var(--muted-foreground) / 0.3);
    border-radius: 3px;
}

main::-webkit-scrollbar-thumb:hover {
    background-color: hsl(var(--muted-foreground) / 0.5);
}
</style>
