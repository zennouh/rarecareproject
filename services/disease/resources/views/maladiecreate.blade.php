<form action="http://localhost:8000/maladies/store" method="POST" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nom de la maladie</label>
        <input type="text" name="name" required 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="3" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
    </div>

    <button type="submit" 
        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
        Enregistrer la maladie
    </button>
</form>