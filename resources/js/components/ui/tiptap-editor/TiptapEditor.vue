<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import {
    AlignCenter,
    AlignJustify,
    AlignLeft,
    AlignRight,
    Bold,
    Code,
    Heading1,
    Heading2,
    Heading3,
    ImageIcon,
    Italic,
    Link as LinkIcon,
    List,
    ListOrdered,
    Quote,
    Redo,
    RemoveFormatting,
    Strikethrough,
    UnderlineIcon,
    Undo,
} from 'lucide-vue-next';
import type { Component } from 'vue';
import { computed, watch } from 'vue';

interface ToolbarButton {
    icon: Component;
    action: () => void;
    title: string;
    active?: boolean;
    disabled?: boolean;
}

interface ToolbarGroup {
    group: string;
    items: ToolbarButton[];
}

interface Props {
    modelValue: string;
    placeholder?: string;
    disabled?: boolean;
    minHeight?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    placeholder: 'Mulai menulis...',
    disabled: false,
    minHeight: '300px',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const editor = useEditor({
    content: props.modelValue,
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose-base max-w-none focus:outline-none min-h-[inherit] px-4 py-3',
        },
    },
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [1, 2, 3],
            },
        }),
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
        Underline,
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                class: 'text-indigo-600 underline',
            },
        }),
        Image.configure({
            HTMLAttributes: {
                class: 'rounded-lg max-w-full h-auto',
            },
        }),
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
});

// Watch for external changes to modelValue
watch(
    () => props.modelValue,
    (newValue) => {
        if (editor.value && editor.value.getHTML() !== newValue) {
            editor.value.commands.setContent(newValue, { emitUpdate: false });
        }
    }
);

// Watch for disabled state
watch(
    () => props.disabled,
    (disabled) => {
        editor.value?.setEditable(!disabled);
    }
);

const setLink = () => {
    const previousUrl = editor.value?.getAttributes('link').href;
    const url = window.prompt('URL', previousUrl);

    if (url === null) return;

    if (url === '') {
        editor.value?.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }

    editor.value?.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};

const addImage = () => {
    const url = window.prompt('Image URL');
    if (url) {
        editor.value?.chain().focus().setImage({ src: url }).run();
    }
};

// Toolbar buttons configuration
const toolbarButtons = computed<ToolbarGroup[]>(() => [
    {
        group: 'history',
        items: [
            { icon: Undo, action: () => editor.value?.chain().focus().undo().run(), title: 'Undo', disabled: !editor.value?.can().undo() },
            { icon: Redo, action: () => editor.value?.chain().focus().redo().run(), title: 'Redo', disabled: !editor.value?.can().redo() },
        ],
    },
    {
        group: 'headings',
        items: [
            { icon: Heading1, action: () => editor.value?.chain().focus().toggleHeading({ level: 1 }).run(), title: 'Heading 1', active: editor.value?.isActive('heading', { level: 1 }) },
            { icon: Heading2, action: () => editor.value?.chain().focus().toggleHeading({ level: 2 }).run(), title: 'Heading 2', active: editor.value?.isActive('heading', { level: 2 }) },
            { icon: Heading3, action: () => editor.value?.chain().focus().toggleHeading({ level: 3 }).run(), title: 'Heading 3', active: editor.value?.isActive('heading', { level: 3 }) },
        ],
    },
    {
        group: 'formatting',
        items: [
            { icon: Bold, action: () => editor.value?.chain().focus().toggleBold().run(), title: 'Bold', active: editor.value?.isActive('bold') },
            { icon: Italic, action: () => editor.value?.chain().focus().toggleItalic().run(), title: 'Italic', active: editor.value?.isActive('italic') },
            { icon: UnderlineIcon, action: () => editor.value?.chain().focus().toggleUnderline().run(), title: 'Underline', active: editor.value?.isActive('underline') },
            { icon: Strikethrough, action: () => editor.value?.chain().focus().toggleStrike().run(), title: 'Strikethrough', active: editor.value?.isActive('strike') },
            { icon: Code, action: () => editor.value?.chain().focus().toggleCode().run(), title: 'Inline Code', active: editor.value?.isActive('code') },
        ],
    },
    {
        group: 'alignment',
        items: [
            { icon: AlignLeft, action: () => editor.value?.chain().focus().setTextAlign('left').run(), title: 'Align Left', active: editor.value?.isActive({ textAlign: 'left' }) },
            { icon: AlignCenter, action: () => editor.value?.chain().focus().setTextAlign('center').run(), title: 'Align Center', active: editor.value?.isActive({ textAlign: 'center' }) },
            { icon: AlignRight, action: () => editor.value?.chain().focus().setTextAlign('right').run(), title: 'Align Right', active: editor.value?.isActive({ textAlign: 'right' }) },
            { icon: AlignJustify, action: () => editor.value?.chain().focus().setTextAlign('justify').run(), title: 'Justify', active: editor.value?.isActive({ textAlign: 'justify' }) },
        ],
    },
    {
        group: 'lists',
        items: [
            { icon: List, action: () => editor.value?.chain().focus().toggleBulletList().run(), title: 'Bullet List', active: editor.value?.isActive('bulletList') },
            { icon: ListOrdered, action: () => editor.value?.chain().focus().toggleOrderedList().run(), title: 'Numbered List', active: editor.value?.isActive('orderedList') },
            { icon: Quote, action: () => editor.value?.chain().focus().toggleBlockquote().run(), title: 'Blockquote', active: editor.value?.isActive('blockquote') },
        ],
    },
    {
        group: 'insert',
        items: [
            { icon: LinkIcon, action: setLink, title: 'Insert Link', active: editor.value?.isActive('link') },
            { icon: ImageIcon, action: addImage, title: 'Insert Image' },
        ],
    },
    {
        group: 'clear',
        items: [
            { icon: RemoveFormatting, action: () => editor.value?.chain().focus().clearNodes().unsetAllMarks().run(), title: 'Clear Formatting' },
        ],
    },
]);
</script>

<template>
    <div
        class="rounded-md border border-input bg-background ring-offset-background focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2">
        <!-- Toolbar -->
        <div v-if="editor"
            class="flex flex-wrap items-center gap-0.5 border-b border-input bg-muted/30 p-1.5 rounded-t-md">
            <template v-for="(group, groupIndex) in toolbarButtons" :key="group.group">
                <TooltipProvider v-for="button in group.items" :key="button.title">
                    <Tooltip>
                        <TooltipTrigger as-child>
                            <Button type="button" variant="ghost" size="sm" :class="[
                                'h-8 w-8 p-0',
                                button.active && 'bg-muted text-foreground',
                            ]" :disabled="button.disabled || disabled" @click="button.action">
                                <component :is="button.icon" class="h-4 w-4" />
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent side="bottom">
                            <p>{{ button.title }}</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
                <Separator v-if="groupIndex < toolbarButtons.length - 1" orientation="vertical" class="mx-1 h-6" />
            </template>
        </div>

        <!-- Editor Content -->
        <div class="relative" :style="{ minHeight: minHeight }">
            <EditorContent :editor="editor"
                class="[&_.ProseMirror]:min-h-[inherit] [&_.ProseMirror]:outline-none [&_.ProseMirror_p.is-editor-empty:first-child::before]:text-muted-foreground [&_.ProseMirror_p.is-editor-empty:first-child::before]:content-[attr(data-placeholder)] [&_.ProseMirror_p.is-editor-empty:first-child::before]:float-left [&_.ProseMirror_p.is-editor-empty:first-child::before]:h-0 [&_.ProseMirror_p.is-editor-empty:first-child::before]:pointer-events-none" />
        </div>
    </div>
</template>

<style>
/* Tiptap Editor Styles */
.ProseMirror {
    min-height: inherit;
    padding: 1rem;
}

.ProseMirror:focus {
    outline: none;
}

/* Placeholder styling */
.ProseMirror p.is-editor-empty:first-child::before {
    color: var(--muted-foreground);
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}

/* Basic typography within editor */
.ProseMirror h1 {
    font-size: 2em;
    font-weight: 900;
    letter-spacing: -0.025em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    line-height: 1.2;
}

.ProseMirror h2 {
    font-size: 1.5em;
    font-weight: 900;
    letter-spacing: -0.025em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    line-height: 1.25;
}

.ProseMirror h3 {
    font-size: 1.25em;
    font-weight: 900;
    letter-spacing: -0.02em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    line-height: 1.3;
}

.ProseMirror p {
    margin-bottom: 1em;
    line-height: 1.75;
}

.ProseMirror ul,
.ProseMirror ol {
    padding-left: 1.5em;
    margin-bottom: 1em;
}

.ProseMirror li {
    margin-bottom: 0.25em;
}

.ProseMirror blockquote {
    border-left: 4px solid var(--border);
    padding-left: 1em;
    margin: 1em 0;
    font-style: italic;
    color: var(--muted-foreground);
}

.ProseMirror pre {
    background: var(--muted);
    border-radius: 0.5em;
    padding: 1em;
    overflow-x: auto;
    margin: 1em 0;
}

.ProseMirror code {
    background: var(--muted);
    padding: 0.2em 0.4em;
    border-radius: 0.25em;
    font-size: 0.9em;
}

.ProseMirror pre code {
    background: transparent;
    padding: 0;
}

.ProseMirror img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5em;
    margin: 1em 0;
}

.ProseMirror a {
    color: var(--primary);
    text-decoration: underline;
}

.ProseMirror hr {
    border: none;
    border-top: 2px solid var(--border);
    margin: 2em 0;
}
</style>
