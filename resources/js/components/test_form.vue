<template>
    <div class="container">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title" style="font-size:20px;font-weight:bold">Test Form</span>

                            <div class="card-tools float-right">
                                <button class="btn btn-success" @click="newModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <th>Arabic Name</th>
                                        <th>Email</th>
                                        <th>Brand Name</th>
                                        <th>Arabic Brand Name</th>
                                        <th>modify</th>
                                    </tr>
                                    <tr v-for="code_table in users.data" :key="code_table.id">
                                        <td>{{ code_table.name }}</td>
                                        <td>{{ code_table.name_ar }}</td>
                                        <td>{{ code_table.email}}</td>
                                        <td>{{ code_table.brand_name}}</td>
                                        <td>{{ code_table.brand_name_ar}}</td>
                                        <td>
                                            <a href="#" @click="editModal(code_table)">
                                                <i class="fa fa-edit"></i>
                                            </a>&nbsp;
                                            <a href="#" @click="deleteUser(code_table.id)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:700px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>

                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="control-label">Name</label>
                                    <input v-model="form.name" required type="text" name="name" placeholder="Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name_ar" class="control-label">Arabic Name</label>
                                    <input v-model="form.name_ar" type="text" name="name_ar" placeholder="Arabic Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }" dir="rtl">
                                    <has-error :form="form" field="name_ar"></has-error>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="brand_name" class="control-label">Brand Name</label>
                                    <input v-model="form.brand_name" required type="text" name="brand_name" placeholder="Brand Name" class="form-control" :class="{ 'is-invalid': form.errors.has('brand_name') }">
                                    <has-error :form="form" field="brand_name"></has-error>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="brand_name_ar" class="control-label">Arabic Brand Name</label>
                                    <input v-model="form.brand_name_ar" type="text" name="brand_name_ar" placeholder="Brand Name" class="form-control" :class="{ 'is-invalid': form.errors.has('brand_name_ar') }" dir="rtl">
                                    <has-error :form="form" field="brand_name_ar"></has-error>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="control-label">Email</label>
                                    <input v-model="form.email" required type="email" name="email" placeholder="Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="col-md-6 form-group custom-file" style="margin-top:30px">
                                    <input type="file" class="custom-file-input" id="cr" name="cr" @change="selectFile">
                                    <label class="custom-file-label" for="cr">Upload CR</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            editmode: false,
            users: {},
            form: new Form({
                id: '',
                name: '',
                name_ar: '',
                email: '',
                brand_name: '',
                brand_name_ar: '',
                cr: '',
            }),
        }
    },

    methods: {
        selectFile(event) {
            this.form.cr = event.target.files[0];
        },

        getResults(page = 1) {
            axios.get('api/form_test?page=' + page).then((res) => {
                this.users = res.data;
            });
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        createUser() {
            this.$Progress.start();
            const data = new FormData();
            data.append('photo', this.form.cr);
            const json = JSON.stringify({
                id: this.form.id,
                name: this.form.name,
                name_ar: this.form.name_ar,
                email: this.form.email,
                brand_name: this.form.brand_name,
                brand_name_ar: this.form.brand_name_ar,
                cr: this.form.cr,
            });
            data.append('data', json);

            axios.post('api/form_test', data).then((res) => {
                if (res.data == 'sizeExceeded')
                    swal.fire(
                        "Failed!",
                        "You Exceed Max Limit File Size",
                        "warning"
                    );
                else if (res.data == 'extensionError')
                    swal.fire(
                        "Failed!",
                        "Extension Error, only PDF Allowed",
                        "warning"
                    );
                else {
                    $("#addNew").modal("hide");
                    swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Created successfully",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.form.reset();
                    Fire.$emit('AfterCreate');
                }
                this.$Progress.finish();
            })
        },

        updateUser() {
            this.$Progress.start();
            const data = new FormData();
            data.append('photo', this.form.cr);
            const json = JSON.stringify({
                id: this.form.id,
                name: this.form.name,
                name_ar: this.form.name_ar,
                email: this.form.email,
                brand_name: this.form.brand_name,
                brand_name_ar: this.form.brand_name_ar,
                cr: this.form.cr,
            });
            data.append('data', json);

            axios.post('api/form_test_update', data).then((res) => {
                if (res.data == 'sizeExceeded')
                    swal.fire(
                        "Failed!",
                        "You Exceed Max Limit File Size",
                        "warning"
                    );
                else if (res.data == 'extensionError')
                    swal.fire(
                        "Failed!",
                        "Extension Error, only PDF Allowed",
                        "warning"
                    );
                else {
                    $("#addNew").modal("hide");
                    swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Updated successfully",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Fire.$emit('AfterCreate');
                }
                this.$Progress.finish();
            }).catch(() => {
                this.$Progress.fail();
            });
        },

        editModal(user) {
            this.editmode = true;
            this.form.reset();
            this.form.fill(user);
            $('#addNew').modal('show');
        },

        deleteUser(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    this.form.delete('api/form_test/' + id).then(() => {
                        swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(() => {
                        swal.fire("Failed!", "There was something wronge.", "warning");
                    });
                }
            })
        },
    },

    created() {
        this.getResults();
        Fire.$on('AfterCreate', () => {
            this.getResults();
        });
    },
}
</script>
