<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { type Student } from '@/types/student';
import { Form, Head, Link } from '@inertiajs/vue3';

interface OptionItem {
    value: string;
    label: string;
}

interface Props {
    student?: Student | null;
    sexeOptions: OptionItem[];
    languageOptions: OptionItem[];
    programOptions: OptionItem[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Students', href: studentsRoutes.index().url },
];
</script>

<template>
    <Head title="Dashboard Create Students" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <Link :href="studentsRoutes.index().url" prefetch>
                        Retour liste étudiants
                    </Link>
                </div>
            </div>

            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="relative p-4">
                    <Form
                        method="post"
                        :action="studentsRoutes.store().url"
                        enctype="multipart/form-data"
                        v-slot="{ errors, processing, reset }"
                    >
                        <!-- -Nom -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium"
                                >Nom</label
                            >
                            <Input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Votre nom complet"
                                class="mt-1 block w-120 rounded"
                            />
                            <p
                                v-if="errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.name }}
                            </p>
                        </div>
Fichier qui prend l'extrait,
                        <!-- -Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium"
                                >Adresse mail</label
                            >
                            <Input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Votre adresse mail: example@gmail.com"
                                class="mt-1 block w-120 rounded"
                            />
                            <p
                                v-if="errors.email"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.email }}
                            </p>
                        </div>

                        <!-- Sexe - -Boutons Radio avec v-for -->
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium"
                                >Sexe</label
                            >
                            <div class="flex gap-4">
                                <label
                                    v-for="option in props.sexeOptions"
                                    :key="option.value"
                                    class="inline-flex cursor-pointer items-center"
                                >
                                    <input
                                        type="radio"
                                        name="sexe"
                                        :value="option.value"
                                        class="mr-2 cursor-pointer"
                                    />
                                    <span>{{ option.label }}</span>
                                </label>
                            </div>
                            <p
                                v-if="errors.sexe"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.sexe }}
                            </p>
                        </div>

                        <!-- Langue avec v-for -->
                        <div class="mb-4">
                            <label
                                for="language"
                                class="mb-2 block text-sm font-medium"
                            >
                                Langue <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="language"
                                name="language"
                                class="w-full rounded-md border border-input bg-background px-3 py-2"
                            >
                                <option value="">
                                    Sélectionnez une langue
                                </option>
                                <option
                                    v-for="option in props.languageOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </select>
                            <p
                                v-if="errors.language"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.language }}
                            </p>
                        </div>

                        <!-- -Pays -->
                        <div class="mb-4">
                            <label
                                for="country"
                                class="mb-2 block text-sm font-medium"
                                >Pays</label
                            >
                            <Input
                                type="text"
                                id="country"
                                name="country"
                                placeholder="Ex: France"
                                class="w-full"
                            />
                            <p
                                v-if="errors.country"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.country }}
                            </p>
                        </div>

                        <!-- -Photo de profil -->
                        <div class="mb-4">
                            <label
                                for="profile"
                                class="mb-2 block text-sm font-medium"
                            >
                                Photo de profil
                            </label>
                            <input
                                type="file"
                                id="profile"
                                name="profile"
                                accept="image/jpeg,image/jpg,image/png,image/webp"
                                class="w-full rounded-md border border-input bg-background px-3 py-2 file:mr-4 file:rounded file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-foreground hover:file:bg-primary/90"
                            />
                            <p class="mt-1 text-xs text-muted-foreground">
                                Formats acceptés: JPG, JPEG, PNG, WEBP (max 2
                                Mo)
                            </p>
                            <p
                                v-if="errors.profile"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.profile }}
                            </p>
                        </div>

                        <!-- -Programmes avec v-for -->
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium"
                                >Programmes</label
                            >
                            <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                                <label
                                    v-for="program in props.programOptions"
                                    :key="program.value"
                                    class="inline-flex cursor-pointer items-center"
                                >
                                    <input
                                        type="checkbox"
                                        name="programs[]"
                                        :value="program.value"
                                        class="mr-2 cursor-pointer rounded"
                                    />
                                    <span>{{ program.label }}</span>
                                </label>
                            </div>
                            <p
                                v-if="errors.programs"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.programs }}
                            </p>
                        </div>

                        <!-- -Biographie -->
                        <div class="mb-6">
                            <label
                                for="bio"
                                class="mb-2 block text-sm font-medium"
                                >Biographie</label
                            >
                            <textarea
                                id="bio"
                                name="bio"
                                rows="4"
                                placeholder="Décrivez-vous en quelques mots... (max 500 caractères)"
                                class="w-full resize-none rounded-md border border-input bg-background px-3 py-2"
                            ></textarea>
                            <p
                                v-if="errors.bio"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.bio }}
                            </p>
                        </div>

                        <!-- Boutons -->
                        <Button
                            type="reset"
                            class="mr-2 bg-primary/50"
                            @click="reset()"
                        >
                            Réinitialiser
                        </Button>
                        <Button type="submit" :disabled="processing">
                            {{
                                processing
                                    ? 'Ajout en cours...'
                                    : 'Ajouter un étudiant'
                            }}
                        </Button>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
input[type='radio']:checked {
    accent-color: hsl(var(--primary));
}

input[type='checkbox']:checked {
    accent-color: hsl(var(--primary));
}
</style>
