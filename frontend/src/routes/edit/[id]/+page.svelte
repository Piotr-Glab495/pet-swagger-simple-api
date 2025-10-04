<script lang="ts">
    import { updatePet } from '$lib';
    import { goto } from '$app/navigation';
    import type { Pet } from '$lib';

    export let data: { pet: Pet | null; error: string | null };

    let pet: Pet | null = data.pet;
    let error: string | null = data.error;

    async function submit() {
        if (!pet) return;
        const res = await updatePet(pet);
        if ('error' in res) error = res.error;
        else goto('/');
    }
</script>

<h1>Edit Pet</h1>
{#if error}<p style="color:red">{error}</p>{/if}

{#if pet}
<form on:submit|preventDefault={submit}>
    <label>
        Name: <input bind:value={pet.name} required>
    </label>
    <br>
    <label>
        Status:
        <select bind:value={pet.status}>
            <option value="available">available</option>
            <option value="pending">pending</option>
            <option value="sold">sold</option>
        </select>
    </label>
    <br>
    <button type="submit">Update Pet</button>
</form>
{/if}
<a href="/">Back to list</a>
