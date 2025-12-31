import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
) {
    const targetUrl = toUrl(urlToCheck);
    const normalizedTarget = normalizeUrl(targetUrl);
    const normalizedCurrent = normalizeUrl(currentUrl);

    // Exact match
    if (normalizedTarget === normalizedCurrent) {
        return true;
    }

    // For dashboard/home routes, only match exactly
    if (normalizedTarget === '/admin' || normalizedTarget === '/') {
        return normalizedCurrent === normalizedTarget;
    }

    // For other routes, check if current URL starts with target URL
    // This handles nested routes like /admin/agenda/create matching /admin/agenda
    return normalizedCurrent.startsWith(normalizedTarget + '/') || normalizedCurrent === normalizedTarget;
}

export function normalizeUrl(url: string): string {
    // Remove trailing slash and query parameters for comparison
    return url.split('?')[0].replace(/\/$/, '') || '/';
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}
