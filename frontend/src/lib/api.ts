export type Pet = {
    id: number;
    name: string;
    status: 'available' | 'pending' | 'sold';
    category: { id: number; name: string };
    tags: { id: number; name: string }[];
    photoUrls: string[];
};

const BASE_URL = '/api';

export async function getPets(status: string = 'available'): Promise<Pet[] | { error: string }> {
    try {
        const res = await fetch(`${BASE_URL}/pets?status=${status}`);
        return await res.json();
    } catch (e: any) {
        return { error: e.message };
    }
}

export async function getPet(id: number): Promise<Pet | { error: string }> {
    try {
        const res = await fetch(`${BASE_URL}/pet/${id}`);
        return await res.json();
    } catch (e: any) {
        return { error: e.message };
    }
}

export async function addPet(pet: Pet): Promise<Pet | { error: string }> {
    try {
        const res = await fetch(`${BASE_URL}/pet`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(pet)
        });
        return await res.json();
    } catch (e: any) {
        return { error: e.message };
    }
}

export async function updatePet(pet: Pet): Promise<Pet | { error: string }> {
    try {
        const res = await fetch(`${BASE_URL}/pet`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(pet)
        });
        return await res.json();
    } catch (e: any) {
        return { error: e.message };
    }
}

export async function deletePet(id: number): Promise<{success: boolean} | { error: string }> {
    try {
        const res = await fetch(`${BASE_URL}/pet/${id}`, { method: 'DELETE' });
        return await res.json();
    } catch (e: any) {
        return { error: e.message };
    }
}