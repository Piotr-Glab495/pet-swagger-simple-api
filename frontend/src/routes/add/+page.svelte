<script lang="ts">
	import type { Pet } from '$lib';
	import { addPet } from '$lib';
	import { goto } from '$app/navigation';

	let id				: number = Math.floor(Math.random() * 1000000);
	let name			: string = '';
	let status			: Pet['status'] = 'available';
	let categoryId		: number = 0;
	let categoryName	: string = '';
	let tags			: { id: number; name: string }[] = [];
	let newTagName		: string = '';
    let newTagId		: number = 0;
	let photoUrls		: string[] = [];
	let newPhotoUrl		: string = '';
	let error			: string | null = null;

	function addTag() {
        tags = [...tags, { id: newTagId, name: newTagName }];
        newTagId = 0; newTagName = '';
    }

    function addPhoto() {
        photoUrls = [...photoUrls, newPhotoUrl];
        newPhotoUrl = '';
    }

	async function submit() {
        const pet: Pet = {
            id,
            name,
            status,
            category: { id: categoryId, name: categoryName },
            tags,
            photoUrls
        };
        const res = await addPet(pet);
        if ('error' in res) error = res.error;
        else goto('/');
    }
</script>

<h1>Add New Pet</h1>
{#if error}<p style="color:red">{error}</p>{/if}
<form on:submit|preventDefault={submit}>
	<label>ID: <input type="number" bind:value={id} /></label><br />
	<label>Name: <input bind:value={name} /></label><br />
	<label>Status:
		<select bind:value={status}>
			<option value="available">available</option>
			<option value="pending">pending</option>
			<option value="sold">sold</option>
		</select>
	</label><br />
	<label>Category ID: <input type="number" bind:value={categoryId} /></label><br />
	<label>Category Name: <input bind:value={categoryName} /></label><br />

	<fieldset>
        <legend>Tags</legend>
        {#each tags as tag}
            <div>{tag.id} - {tag.name}</div>
        {/each}
        <input type="number" bind:value={newTagId} placeholder="Tag ID" />
        <input bind:value={newTagName} placeholder="Tag Name" />
        <button type="button" on:click={addTag}>Add Tag</button>
    </fieldset>

    <fieldset>
        <legend>Photo URLs</legend>
        {#each photoUrls as url}
            <div>{url}</div>
        {/each}
        <input bind:value={newPhotoUrl} placeholder="Photo URL" />
        <button type="button" on:click={addPhoto}>Add Photo</button>
    </fieldset>

    <button type="submit">Add Pet</button>
</form>
<a href="/">Back to list</a>
