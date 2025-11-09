<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link } from '@inertiajs/vue3';


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
    <Head title="Dashboard Create Students" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                   <Link :href="studentsRoutes.index().url" prefetch >Retour liste etudiants</Link>
                </div>
    
              
                
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="relative p-4">
                    <Form method="post" :action="studentsRoutes.store().url"
                    v-slot="{ errors, processing, wasSuccessful, defaults, reset}"
                    resetOnError
                    >
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">Nom</label>
                            <Input
                                type="text"
                                id="name"
                                name="name"
                                class="mt-1 block w-120 rounded"
                               
                            />
                            <p v-if="errors.name" class="text-sm text-red-600 mt-1">{{ errors.name }}</p>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium">Adresse mail</label>
                            <Input
                                type="text"
                                id="email"
                                name="email"
                                class="mt-1 block w-120 rounded"
                                defaultValue="Rostand"
                                placeholder="Votre adresse mail :example@gmail.com"
                               
                            />
                            <p v-if="errors.email" class="text-sm text-red-600 mt-1">{{ errors.email }}</p>
                        </div>
                       

                        <Button type="reset"  class="mr-2 bg-primary/50" @click="reset()">
                        Rénitialiser
                        </Button>
                        <Button  type="submit"  class=""  :disabled="processing">
                           {{ processing ? "Ajout en cours... ": "Ajouter un étudiant" }} 
                        </Button>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
