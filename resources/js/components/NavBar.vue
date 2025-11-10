<script setup lang="ts">
// import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';

import { dashboard, login, register } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import AppLogo from './AppLogo.vue';

// Import des icônes lucide-vue-next
import {
    Layers,
    Lightbulb,
    MenuIcon,
    UserPlusIcon,
    XIcon,
} from 'lucide-vue-next';
import ThemeToggle from './ThemeToggle.vue';

// État du menu mobile
const open = ref(false);

// Gestion de l'ombre au scroll
const hasShadow = ref(false);

onMounted(() => {
    const handleScroll = () => {
        hasShadow.value = window.scrollY > 10;
    };
    window.addEventListener('scroll', handleScroll);

    onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll);
    });
});

// Liens principaux avec icônes
interface NavLink {
    name: string;
    href: string;
    icon: any; // Type de composant Vue
    isFree?: boolean;
}
const links: NavLink[] = [
    { name: 'Formations', href: '/formations', icon: Layers, isFree: true },
    { name: 'Blog', href: '/blog', icon: Lightbulb },
];
</script>

<template>
    <header
        :class="[
            'sticky top-0 z-50 border-b border-border bg-[var(--card)] transition-shadow duration-200',
            hasShadow ? 'shadow-lg' : 'shadow-none',
        ]"
    >
        <!-- Bannière promotionnelle animée -->
        <div
            class="topHead flex h-7 items-center justify-center text-xs sm:text-sm"
        >
            <a
                href="https://hostinger.fr/?REFERRALCODE=1ROSTO35"
                target="_blank"
                rel="noopener"
                aria-label="Hostinger - Bénéficiez de -20% sur l'hébergement"
                class="flex items-center gap-1.5 font-medium text-[#eefff5] sm:gap-2"
            >
                <span class="font-bold">-20%</span>
                <span>d'hébergement chez</span>
                <span class="flex items-center gap-1 font-extrabold">
                    <svg
                        style="color: #fff"
                        class="h-4 w-4 text-white sm:h-4 sm:w-4"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        height="2500"
                        stroke-linejoin="round"
                        stroke-miterlimit="2"
                        viewBox="7.002 8.287 148.203 175.426"
                        width="2112"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="m7.002 8.287 39.319 21.172v39.32h57.467l36.295 21.172h-133.081zm148.203 75.615v-54.443l-42.344-21.172v51.418zm0 99.811-39.319-21.172v-39.32h-57.467l-36.295-21.172h133.081zm-148.203-75.615v54.443l42.343 21.172v-51.418z"
                            fill="#fff"
                        />
                    </svg>

                    <span>Hostinger</span>
                </span>
            </a>
        </div>

        <!-- Navigation principale -->
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 md:px-9 lg:px-6">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo + Desktop Links -->
                <Link href="/" prefetch class="flex items-center">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-md"
                    >
                        <AppLogo
                            class="h-5 w-5 fill-current text-primary-foreground dark:text-primary-foreground"
                        />
                    </div>
                    <span class="ml-2 text-xl font-bold text-primary"
                        >Course</span
                    >
                </Link>

                <!-- Liens desktop -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <Link
                        v-for="link in links"
                        :key="link.name"
                        :href="link.href"
                        prefetch
                        class="flex items-center gap-2 text-gray-700 transition-colors duration-200 hover:text-primary dark:text-gray-200 dark:hover:text-primary"
                    >
                        <component :is="link.icon" class="h-4 w-4" />
                        <span>{{ link.name }}</span>
                        <span
                            v-if="link.isFree"
                            class="rounded-sm bg-primary px-1.5 pt-0.5 text-xs font-semibold text-white uppercase shadow-sm"
                        >
                            FREE
                        </span>
                    </Link>
                </div>

                <ul class="flex gap-2 md:hidden">
                    <li>
                        <Link href="/formations" prefetch>
                            <div class="flex items-center gap-1">
                                <Layers class="h-3 w-3" /> Formations
                            </div>
                        </Link>
                    </li>
                    <!-- <li class="sm:hidden"> <Link href="/blog" prefetch>
                            <div class="flex items-center gap-1">
                                <Lightbulb class=" w-3 h-3"/> Blog  
                            </div> 
                            </Link>
                        </li> -->
                </ul>

                <!-- Actions (thème + auth + bouton mobile) -->
                <div class="flex items-center space-x-4">
                    <!-- Bouton mobile -->
                    <button
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-controls="mobile-menu"
                        class="rounded p-2 text-gray-700 hover:text-primary focus:ring-2 focus:ring-primary focus:outline-none md:hidden dark:text-gray-200"
                    >
                        <span class="sr-only">{{
                            open ? 'Fermer le menu' : 'Ouvrir le menu'
                        }}</span>
                        <span class="flex items-center space-x-2">
                            <div>
                                <component
                                    :is="open ? XIcon : MenuIcon"
                                    class="h-6 w-6"
                                />
                            </div>
                            <span class="font-bold">Menu</span>
                        </span>
                    </button>

                    <!-- Composants desktop -->
                    <div class="hidden items-center space-x-4 md:flex">
                        <ThemeToggle />
                        <span class="text-gray-400">|</span>
                        <Link
                            v-if="$page.props.auth?.user"
                            :href="dashboard()"
                            prefetch
                            class="inline-block rounded-lg border border-primary/20 px-5 py-2 text-sm leading-normal text-foreground transition-colors hover:bg-primary/10 dark:hover:bg-primary/20"
                        >
                            Tableau de bord
                        </Link>
                        <template v-else>
                            <Link
                                :href="register()"
                                @click="open = false"
                                prefetch
                                class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium text-foreground transition hover:bg-muted hover:text-primary"
                            >
                                <UserPlusIcon class="h-4 w-4" />
                                S'inscrire
                            </Link>
                            <Link
                                :href="login()"
                                prefetch
                                class="dark:bg-primary-dark dark:hover:bg-primary-dark/90 flex items-center gap-2 rounded-lg border-1 border-primary px-5 py-2 text-sm leading-normal shadow-sm transition-colors hover:bg-primary/90"
                            >
                                Se connecter
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu mobile -->
        <transition
            enter-active-class="transition ease-out duration-200 transform"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150 transform"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-show="open"
                id="mobile-menu"
                class="border-t border-border bg-white md:hidden dark:bg-gray-900"
            >
                <div class="space-y-1 px-4 py-3">
                    <!-- Liens principaux -->

                    <Link
                        v-for="link in links"
                        :key="link.name"
                        :href="link.href"
                        @click="open = false"
                        prefetch
                        class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium text-gray-700 transition-colors duration-150 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800"
                    >
                        <component :is="link.icon" class="h-4 w-4" />
                        {{ link.name }}
                        <span
                            v-if="link.isFree"
                            class="rounded-sm bg-primary px-1.5 pt-0.5 text-xs font-semibold text-white uppercase shadow-sm"
                        >
                            FREE
                        </span>
                    </Link>

                    <!-- Auth links -->
                    <div
                        class="space-y-1 border-t border-gray-200 pt-2 dark:border-gray-700"
                    >
                        <Link
                            v-if="$page.props.auth.user"
                            :href="dashboard()"
                            prefetch
                            class="block rounded-md bg-primary px-3 py-2 text-center text-base font-medium text-gray-700 transition-colors duration-150 hover:bg-primary dark:text-gray-200 dark:hover:bg-gray-800"
                        >
                            Tableau de bord
                        </Link>

                        <div v-else>
                            <Link
                                :href="register()"
                                @click="open = false"
                                prefetch
                                class="flex items-center justify-center gap-2 rounded-md bg-primary px-3 py-2 text-center text-base font-medium text-gray-700 transition-colors duration-150 hover:bg-primary dark:text-gray-200 dark:hover:bg-gray-800"
                            >
                                <UserPlusIcon class="h-4 w-4" />
                                S'enregistrer
                            </Link>

                            <div
                                class="mt-4 flex items-center justify-center space-y-2"
                            >
                                <span class="mt-2 text-muted-foreground"
                                    >Déjà un compte ?</span
                                >
                                <Link
                                    :href="login()"
                                    @click="open = false"
                                    prefetch
                                    class="flex items-center gap-2 rounded-md px-3 py-2 text-base font-medium transition-colors duration-150 dark:text-gray-200 dark:hover:bg-gray-800"
                                >
                                    Se connecter
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.topHead {
    background: linear-gradient(270deg, #041e13, #032e11, #0d4200, #ff2d55);
    background-size: 400% 400%;
    animation: gradientAnimation 10s ease infinite;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.dim {
    transform: scale(0.3) !important;
}
</style>
