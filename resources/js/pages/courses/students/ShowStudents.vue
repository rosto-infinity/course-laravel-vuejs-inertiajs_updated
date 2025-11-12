<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { type Student } from '@/types/student';
import { Head, Link } from '@inertiajs/vue3';

interface OptionItem {
    value: string;
    label: string;
}

interface Props {
    student: Student;
    sexeOptions?: OptionItem[];
    languageOptions?: OptionItem[];
    programOptions?: OptionItem[];
}

const props = defineProps<Props>();

// Fonction pour obtenir le label d'une option
const getOptionLabel = (options: OptionItem[] | undefined, value: string): string => {
    if (!options) return value;
    return options.find(option => option.value === value)?.label || value;
};

// Fonction pour obtenir les labels des programmes
const getProgramsLabels = (): string[] => {
    if (!props.student.programs) return [];
    return props.student.programs.map(
        programValue => getOptionLabel(props.programOptions, programValue)
    );
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Students', href: studentsRoutes.index().url },
    { title: props.student.name, href: '#' },
];
</script>

<template>
    <Head :title="`Détails - ${student.name}`" />

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

                <!-- Actions rapides -->
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <Link
                        :href="studentsRoutes.edit({ student: student.id }).url"
                        prefetch
                    >
                        <Button class="w-full">
                            <svg
                                class="mr-2 h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                            Modifier
                        </Button>
                    </Link>
                </div>
            </div>

            <!-- Contenu principal -->
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="relative p-6">
                    <!-- En-tête avec photo -->
                    <div class="mb-8 flex flex-col items-center gap-6 border-b pb-8 md:flex-row">
                        <!-- Photo de profil -->
                        <div class="flex-shrink-0">
                            <div v-if="student.profile_url" class="relative">
                                <img
                                    :src="student.profile_url"
                                    :alt="student.name"
                                    class="h-32 w-32 rounded-full border-4 border-gray-200 object-cover shadow-lg dark:border-gray-700"
                                />
                            </div>
                            <div v-else class="relative">
                                <div
                                    class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-gray-200 bg-gradient-to-br from-indigo-500 to-purple-600 text-5xl font-bold text-white shadow-lg dark:border-gray-700"
                                >
                                    {{ student.name.charAt(0).toUpperCase() }}
                                </div>
                            </div>
                        </div>

                        <!-- Informations principales -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold">{{ student.name }}</h1>
                            <p class="mt-2 flex items-center justify-center gap-2 text-lg text-muted-foreground md:justify-start">
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                                {{ student.email }}
                            </p>
                            <div class="mt-3 flex flex-wrap items-center justify-center gap-2 md:justify-start">
                                <span
                                    class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                                >
                                    {{ getOptionLabel(sexeOptions, student.sexe) }}
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300"
                                >
                                    🌍 {{ student.country }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Grille d'informations -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Informations personnelles -->
                        <div class="rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                            <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold">
                                <svg
                                    class="h-5 w-5 text-primary"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                Informations personnelles
                            </h2>

                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">
                                        Langue
                                    </p>
                                    <p class="mt-1 text-base font-semibold">
                                        {{ getOptionLabel(languageOptions, student.language) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">
                                        Pays
                                    </p>
                                    <p class="mt-1 text-base font-semibold">
                                        {{ student.country }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">
                                        Sexe
                                    </p>
                                    <p class="mt-1 text-base font-semibold">
                                        {{ getOptionLabel(sexeOptions, student.sexe) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Programmes maîtrisés -->
                        <div class="rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                            <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold">
                                <svg
                                    class="h-5 w-5 text-primary"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                                    />
                                </svg>
                                Programmes maîtrisés
                            </h2>

                            <div v-if="student.programs && student.programs.length > 0" class="flex flex-wrap gap-2">
                                <span
                                    v-for="programLabel in getProgramsLabels()"
                                    :key="programLabel"
                                    class="inline-flex items-center rounded-md bg-green-100 px-3 py-1.5 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-300"
                                >
                                    {{ programLabel }}
                                </span>
                            </div>
                            <p v-else class="text-sm text-muted-foreground">
                                Aucun programme renseigné
                            </p>
                        </div>
                    </div>

                    <!-- Biographie -->
                    <div v-if="student.bio" class="mt-6 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold">
                            <svg
                                class="h-5 w-5 text-primary"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7"
                                />
                            </svg>
                            Biographie
                        </h2>
                        <p class="text-base leading-relaxed text-muted-foreground">
                            {{ student.bio }}
                        </p>
                    </div>

                    <!-- Métadonnées -->
                    <div class="mt-6 rounded-lg border border-sidebar-border/70 bg-muted/30 p-4">
                        <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
                            <div v-if="student.created_at" class="flex items-center gap-2">
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
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                    />
                                </svg>
                                <span>Créé le : {{ new Date(student.created_at).toLocaleDateString('fr-FR') }}</span>
                            </div>
                            <div v-if="student.updated_at" class="flex items-center gap-2">
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
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                    />
                                </svg>
                                <span>Modifié le : {{ new Date(student.updated_at).toLocaleDateString('fr-FR') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Styles personnalisés si nécessaire */
</style>