
export type Sexe ='male' | 'female' | 'other';
export type Language = 'fr' | 'en';
export type Program = 'php' | 'js' | 'html' | 'typescript' | 'vuejs' | 'nuxtjs' | 'laravel';

export interface Student {
    id: number;
    name: string;
    email: string;
    sexe: Sexe;
     programs: Program[];
    profile: string | null;
    country: string;
    language: Language;
    bio: string | null;
    created_at?: string;
}