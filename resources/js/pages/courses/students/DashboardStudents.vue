<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { Student } from '@/types/student';
import { Head, Link ,router} from '@inertiajs/vue3';
import * as studentsRoute from '@/routes/students';

import { Eye, Pencil, Plus, Trash2 } from 'lucide-vue-next';

interface Props {
    students: Student;
}

const props = defineProps<Props>();

// -Supprimer un étudiant
const deleteStudent = (student: Student) => {
    if (confirm(`Voulez-vous vraiment supprimer ${student.name} ?`)) {
        router.delete(studentsRoute.destroy(student.id).url);
    }
};
// -Badge de couleur pour les sexes
const getSexeColor = (sexe: string) => {
    const colors = {
        male: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        female: 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
        other: 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
    };
    return colors[sexe as keyof typeof colors] || colors.other;
};

const getSexeLabel = (sexe: string) => {
    const labels = {
        male: 'Masculin',
        female: 'Féminin',
        other: 'Autre',
    };
    return labels[sexe as keyof typeof labels] || sexe;
};
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Students',
        href: studentsRoutes.index().url,
    },
];
</script>

<template>
    <Head title="Dashboard Students" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-5"
                >
                <Button> 
                    <Link :href="studentsRoutes.create().url" prefetch >Ajouter un étudiant</Link>
                </Button>
                </div>
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                   Nombre d'étudiants
                </div>
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                   Nombre d'étudiants
                </div>
              
                
            </div>
              <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <!-- Card principale -->
            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5 dark:bg-gray-800 dark:ring-gray-700">
                <!-- Header -->
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Étudiants</h2>
                        <Link
                            :href="studentsRoute.create().url"
                            class="inline-flex items-center justify-center gap-2 rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-green-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-green-600 dark:bg-green-500 dark:hover:bg-green-400"
                        >
                            <Plus class="h-4 w-4" />
                            Nouvel étudiant
                        </Link>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-6 p-6">
                    <!-- Tableau responsive -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Photo
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Nom
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Email
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Sexe
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Programmes
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Pays
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-4 py-3 text-right text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <!-- Message si aucun résultat -->
                                <tr v-if="students.data.length === 0">
                                    <p class="text-center font-medium">Aucun étudiant trouvé</p>
                                </tr>

                                <!-- Lignes des étudiants -->
                                <tr
                                    v-for="student in props.students.data"
                                    :key="student.id"
                                    class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50"
                                >
                                    <!-- Photo -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <img
                                            v-if="student.profile_url"
                                            :src="student.profile_url"
                                            :alt="student.name"
                                            class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                                        />
                                        <div
                                            v-else
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-purple-600 text-sm font-semibold text-white ring-2 ring-gray-200 dark:ring-gray-700"
                                        >
                                            {{ student.name.charAt(0).toUpperCase() }}
                                        </div>
                                    </td>

                                    <!-- Nom -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ student.name }}
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ student.email }}
                                        </div>
                                    </td>

                                    <!-- Sexe -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            :class="getSexeColor(student.sexe)"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                        >
                                            {{ getSexeLabel(student.sexe) }}
                                        </span>
                                    </td>

                                    <!-- Programmes -->
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span
                                                v-for="program in student.programs"
                                                :key="program"
                                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-0.5 text-xs font-medium text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
                                            >
                                                {{ program.toUpperCase() }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Pays -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ student.country }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Voir -->
                                            <Link
                                                :href="studentsRoute.show(student.id).url"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-md text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                                title="Voir les détails"
                                            >
                                                <Eye class="h-4 w-4" />
                                            </Link>

                                            <!-- Modifier -->
                                            <Link
                                                :href="studentsRoute.edit(student.id)"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-md text-green-600 transition-colors hover:bg-green-50 hover:text-green-700 dark:text-green-400 dark:hover:bg-green-900/20 dark:hover:text-green-300"
                                                title="Modifier"
                                            >
                                                <Pencil class="h-4 w-4" />
                                            </Link>

                                            <!-- Supprimer -->
                                            <button
                                                type="button"
                                                @click="deleteStudent(student)"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-600 transition-colors hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300"
                                                title="Supprimer"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </AppLayout>
</template>
