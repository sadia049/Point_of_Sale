<div class="modal" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID" />
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="submit" id="delete-modal-close" class="btn shadow-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {

        let id = document.getElementById('deleteID').value;
        try {
            showLoader();
            let res = await axios.post('/delete-customer', {
                id: id
            })
            hideLoader();
            if (res.status === 200) {
                successToast("Request completed");

                setTimeout(async function() {
                    window.location.href = '/customerPage'
                }, 2000)


            } else {
                errorToast("Request fail!")
            }

        } catch (error) {

            errorToast("Request fail!")




        }
    }
</script>