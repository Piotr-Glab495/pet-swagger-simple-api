//import type { PageLoad } from './$types';
import { getPet } from '$lib';
import type { Pet } from '$lib';

export const load = async ({ params }) => {
    const res = await getPet(Number(params.id));
    if ('error' in res) {
        return { pet: null, error: res.error };
    }
    return { pet: res as Pet, error: null };
};