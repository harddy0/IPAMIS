<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 shadow-lg w-1/3">
        <h2 id="modal-title" class="text-xl font-bold mb-4"></h2>
        <p id="modal-message" class="mb-6"></p>
        <div class="flex justify-end">
            <button id="modal-cancel-button" class="px-4 py-2 bg-gray-500 text-white rounded-lg mr-2" onclick="toggleModal(false)">Cancel</button>
            <button id="modal-confirm-button" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
        </div>
    </div>
</div>

<script>
/**
 * Function to toggle the modal visibility
 * @param {boolean} show - Pass true to show the modal, false to hide it
 */
function toggleModal(show) {
    const modal = document.getElementById('modal');
    modal.classList.toggle('hidden', !show);
}
</script>
