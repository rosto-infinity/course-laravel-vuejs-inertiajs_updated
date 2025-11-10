<script setup lang="ts">
import { ref, computed } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link } from '@inertiajs/vue3';
import { type Student } from '@/types/student';

interface OptionItem {
    value: string;
    label: string;
}

interface Props {
    student: Student;
    sexeOptions: OptionItem[];
    languageOptions: OptionItem[];
    programOptions: OptionItem[];
}

const props = defineProps<Props>();

// État local pour la prévisualisation de l'image
const profilePreview = ref<string | null>(props.student.profile_url || null);
const bioValue = ref(props.student.bio || '');
const bioLength = computed(() => bioValue.value.length);
const bioMaxLength = 500;

// Gérer le changement d'image
const handleImageChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            profilePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Students', href: studentsRoutes.index().url },
    { title: 'Edit', href: '#' },
];
</script>

<template>
    <Head :title="`Modifier ${student.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <!-- Barre de navigation -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <Link 
                        :href="studentsRoutes.index().url" 
                        prefetch
                        class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la liste des étudiants
                    </Link>
                </div>
            </div>

            <!-- Formulaire d'édition -->
            <div class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="relative p-6">
                    <!-- En-tête -->
                    <div class="mb-6 border-b pb-4">
                        <h1 class="text-2xl font-bold">Modifier l'étudiant</h1>
                        <p class="text-sm text-muted-foreground mt-1">
                            Modifiez les informations de {{ student.name }}
                        </p>
                    </div>

                    <Form 
                        method="post" 
                        :action="studentsRoutes.update({ student: student.id }).url"
                        enctype="multipart/form-data"
                        v-slot="{ errors, processing, reset }"
                    >
                        <!-- Méthode PUT pour Laravel -->
                        <input type="hidden" name="_method" value="PUT" />

                        <!-- Grid layout pour le formulaire -->
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            
                            <!-- Colonne gauche -->
                            <div class="space-y-6">
                                
                                <!-- Nom -->
                                <div>
                                    <label for="name" class="block text-sm font-medium mb-2">
                                        Nom complet <span class="text-red-500">*</span>
                                    </label>
                                    <Input
                                        type="text"
                                        id="name"
                                        name="name"
                                        :default-value="student.name"
                                        placeholder="Votre nom complet"
                                        class="w-full"
                                    />
                                    <p v-if="errors.name" class="text-sm text-red-600 mt-1">
                                        {{ errors.name }}
                                    </p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium mb-2">
                                        Adresse email <span class="text-red-500">*</span>
                                    </label>
                                    <Input
                                        type="email"
                                        id="email"
                                        name="email"
                                        :default-value="student.email"
                                        placeholder="example@gmail.com"
                                        class="w-full"
                                    />
                                    <p v-if="errors.email" class="text-sm text-red-600 mt-1">
                                        {{ errors.email }}
                                    </p>
                                </div>

                                <!-- Sexe -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Sexe <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4">
                                        <label 
                                            v-for="option in props.sexeOptions" 
                                            :key="option.value"
                                            class="inline-flex items-center cursor-pointer"
                                        >
                                            <input 
                                                type="radio" 
                                                name="sexe" 
                                                :value="option.value"
                                                :checked="student.sexe === option.value"
                                                class="mr-2 cursor-pointer"
                                            />
                                            <span>{{ option.label }}</span>
                                        </label>
                                    </div>
                                    <p v-if="errors.sexe" class="text-sm text-red-600 mt-1">
                                        {{ errors.sexe }}
                                    </p>
                                </div>

                                <!-- Langue -->
                                <div>
                                    <label for="language" class="block text-sm font-medium mb-2">
                                        Langue <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        id="language" 
                                        name="language"
                                        class="w-full px-3 py-2 border border-input rounded-md bg-background"
                                    >
                                        <option value="">Sélectionnez une langue</option>
                                        <option 
                                            v-for="option in props.languageOptions" 
                                            :key="option.value"
                                            :value="option.value"
                                            :selected="student.language === option.value"
                                        >
                                            {{ option.label }}
                                        </option>
                                    </select>
                                    <p v-if="errors.language" class="text-sm text-red-600 mt-1">
                                        {{ errors.language }}
                                    </p>
                                </div>

                                <!-- Pays -->
                                <div>
                                    <label for="country" class="block text-sm font-medium mb-2">
                                        Pays <span class="text-red-500">*</span>
                                    </label>
                                    <Input
                                        type="text"
                                        id="country"
                                        name="country"
                                        :default-value="student.country"
                                        placeholder="Ex: France"
                                        class="w-full"
                                    />
                                    <p v-if="errors.country" class="text-sm text-red-600 mt-1">
                                        {{ errors.country }}
                                    </p>
                                </div>
                            </div>

                            <!-- Colonne droite -->
                            <div class="space-y-6">
                                
                                <!-- Photo de profil -->
                                <div>
                                    <label for="profile" class="block text-sm font-medium mb-2">
                                        Photo de profil
                                    </label>
                                    
                                    <!-- Prévisualisation de l'image actuelle -->
                                    <div v-if="profilePreview" class="mb-3">
                                        <img
                                            :src="profilePreview"
                                            :alt="student.name"
                                            class="h-32 w-32 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
                                        />
                                    </div>
                                    <div v-else class="mb-3">
                                        <div class="h-32 w-32 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold border-2 border-gray-200 dark:border-gray-700">
                                            {{ student.name.charAt(0).toUpperCase() }}
                                        </div>
                                    </div>

                                    <input
                                        type="file"
                                        id="profile"
                                        name="profile"
                                        accept="image/jpeg,image/jpg,image/png,image/webp"
                                        @change="handleImageChange"
                                        class="w-full px-3 py-2 border border-input rounded-md bg-background file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90"
                                    />
                                    <p class="text-xs text-muted-foreground mt-1">
                                        Formats acceptés: JPG, JPEG, PNG, WEBP (max 2 Mo)
                                    </p>
                                    <p v-if="errors.profile" class="text-sm text-red-600 mt-1">
                                        {{ errors.profile }}
                                    </p>
                                </div>

                                <!-- Programmes -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Programmes maîtrisés <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label 
                                            v-for="optionprogram in props.programOptions" 
                                            :key="optionprogram.value"
                                            class="inline-flex items-center cursor-pointer"
                                        >
                                            <input 
                                                type="checkbox" 
                                                name="programs[]" 
                                                :value="optionprogram.value"
                                                :checked="student.programs?.includes(optionprogram.value)"
                                                class="mr-2 cursor-pointer rounded"
                                            />
                                            <span>{{ optionprogram.label }}</span>
                                        </label>
                                    </div>
                                    <p v-if="errors.programs" class="text-sm text-red-600 mt-1">
                                        {{ errors.programs }}
                                    </p>
                                </div>

                                <!-- Biographie -->
                                <div>
                                    <label for="bio" class="block text-sm font-medium mb-2">
                                        Biographie
                                    </label>
                                    <textarea
                                        id="bio"
                                        name="bio"
                                        v-model="bioValue"
                                        rows="6"
                                        :maxlength="bioMaxLength"
                                        placeholder="Décrivez-vous en quelques mots..."
                                        class="w-full px-3 py-2 border border-input rounded-md bg-background resize-none"
                                    ></textarea>
                                    <p class="flex justify-between text-xs text-muted-foreground mt-1">
                                        <span>{{ bioLength }}/{{ bioMaxLength }} caractères</span>
                                        <span>Facultatif</span>
                                    </p>
                                    <p v-if="errors.bio" class="text-sm text-red-600 mt-1">
                                        {{ errors.bio }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                            
                            <Button 
                                type="reset" 
                                variant="outline"
                                @click="reset()"
                                :disabled="processing"
                            >
                                Réinitialiser
                            </Button>
                            <Button 
                                type="submit" 
                                :disabled="processing"
                            >
                                <span v-if="processing">Mise à jour en cours...</span>
                                <span v-else>Mettre à jour</span>
                            </Button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
input[type="radio"]:checked {
    accent-color: hsl(var(--primary));
}

input[type="checkbox"]:checked {
    accent-color: hsl(var(--primary));
}
</style>