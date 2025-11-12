<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import FormStudents from './FormStudents.vue';

interface OptionItem {
    value: string;
    label: string;
}

interface Props {
    sexeOptions: OptionItem[];
    languageOptions: OptionItem[];
    programOptions: OptionItem[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Students', href: studentsRoutes.index().url },
    { title: 'Créer', href: '#' },
];
</script>

<template>
    <Head title="Ajouter un étudiant" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Barre de navigation -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <Link
                        :href="studentsRoutes.index().url"
                        prefetch
                        class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Retour à la liste des étudiants
                    </Link>
                </div>
            </div>

            <!-- Formulaire -->
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <FormStudents
                    :sexe-options="props.sexeOptions"
                    :language-options="props.languageOptions"
                    :program-options="props.programOptions"
                    :action-url="studentsRoutes.store().url"
                    :is-edit="false"
                />
            </div>
        </div>
    </AppLayout>
</template>