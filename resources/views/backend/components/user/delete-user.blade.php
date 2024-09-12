<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input name="id" type="hidden"  id="deleteID" />
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {
        let id = document.getElementById("deleteID").value;
        document.getElementById("delete-modal-close").click();
        // showLoader();
        let res = await axios.post("/dashboard/user-delete",{id:id})
        // hideLoader();
        if(res.status === 200 && res.data["msg"] === "success"){
            // alert("Catagory Delete Successfully")
            alertify.set('notifier', 'position', 'top-right');
                alertify.success(res.data.data);
            await getList();
        }
        // else{
        //     alert("Request fail!")
        // }
    }
</script>