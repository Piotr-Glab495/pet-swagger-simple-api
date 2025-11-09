<script lang="ts">
	import { onMount } from 'svelte';
	import { getPets, deletePet } from '$lib';
	import type { Pet } from '$lib';

	let pets: Pet[] = [];
	let error: string | null = null;
	let filterStatus: string = 'available';

	async function loadPets(status: string = 'available') {
		const res = await getPets(status);
		if ('error' in res) error = res.error;
		else pets = res;
	}

	async function remove(id: number) {
		const res = await deletePet(id);
		if ('error' in res) error = res.error;
		else await loadPets(filterStatus);
	}

	function onFilterChange() {
        loadPets(filterStatus);
    }

	onMount(loadPets);
</script>

<h1>Pets List</h1>

<label>Filter by status:
    <select bind:value={filterStatus} on:change={onFilterChange}>
        <option value="available">available</option>
        <option value="pending">pending</option>
        <option value="sold">sold</option>
    </select>
</label>

{#if error}
	<p style="color:red">{error}</p>
{/if}

<a href="/add">Add new pet</a>
<table border="1" cellpadding="5" style="width: 75%;">
	<thead style="width: 75%;">
		<tr style="width: 75%;">
			<th>ID</th>
			<th>Name</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody style="width: 75%;">
		{#each pets as pet}
			<tr style="width: 75%;">
				<td>{pet.id}</td>
				<td>{pet.name}</td>
				<td>{pet.status}</td>
				<td>
					<a href={`/edit/${pet.id}`}>Edit</a>
					<button on:click={() => remove(pet.id)}>Delete</button>
				</td>
			</tr>
		{/each}
	</tbody>
</table>

<a href="/add">Add new pet</a>
