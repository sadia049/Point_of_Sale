<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h6>Category</h6>
                    </div>
                    <div class="align-items-center col">
                        <button data-toggle="modal" data-target="#create-modal" class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table  table-flush" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    getList();
    async function getList() {
        try {
            let tableData = $('#tableData');
            let tableList = $("#tableList");

            showLoader();
            let res = await axios.get('/list-customer');
            hideLoader();

            if (res.status === 200) {

                res.data.forEach(function(item, index) {

                    let row = `<tr>

            <td>${index+1}</td>
            <td>${item['name']}</td>
            <td>${item['email']}</td>
            <td>${item['mobile']}</td>
        <td>
            <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
        </td>
    
            
            </tr>`

                    tableList.append(row);
                });

                $('.deleteBtn').on('click', async function() {

                    let id = $(this).data('id');
                    $('#deleteID').val(id)
                    
                    $('#delete-modal').modal('show');


                })

                $('.editBtn').on('click', async function() {

                    let id = $(this).data('id')
                    await FillUpUpdateForm(id)
                    $('#update-modal').modal('show');


                })

    // new DataTable('#tableData',{
    //     order:[[0,'desc']],
    //     lengthMenu:[4,8,16,20,30]
    // });
            } else {

                alert('Something went wrong');

            }

        } catch (error) {
            alert(error);
        }





    }
</script>