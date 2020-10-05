<!-- eslint-disable no-undef -->
<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Users
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">
                Users
              </li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  aaa
                </h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input
                      type="text"
                      name="table_search"
                      class="form-control float-right"
                      placeholder="Search"
                    />

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search" />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div
                class="card-body table-responsive p-0"
                style="height: 300px;"
              >
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-lg-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  New User Form
                </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form
                class="form-horizontal"
                @submit.prevent="onSubmit"
                @keydown="form.errors.clear()"
              >
                <div class="card-body" style="height: 239px;">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label"
                      >Name</label
                    >
                    <div class="col-sm-10">
                      <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        name="name"
                        required
                        autocomplete="name"
                        autofocus
                        placeholder="Name"
                      />
                      <span
                        v-if="form.errors.has('name')"
                        class="invalid-feedback d-block"
                        role="alert"
                        v-text="form.errors.get('name')"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"
                      >Email</label
                    >
                    <div class="col-sm-10">
                      <input
                        id="inputEmail3"
                        v-model="form.email"
                        type="text"
                        class="form-control"
                        placeholder="Email"
                        required
                      />
                      <span
                        v-if="form.errors.has('email')"
                        class="invalid-feedback d-block"
                        role="alert"
                        v-text="form.errors.get('email')"
                      />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label"
                      >Password</label
                    >
                    <div class="col-sm-10">
                      <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        required
                      />
                      <span
                        v-if="form.errors.has('password')"
                        class="invalid-feedback d-block"
                        role="alert"
                        v-text="form.errors.get('password')"
                      />
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button
                    type="submit"
                    class="btn btn-info"
                    :disabled="form.errors.any()"
                  >
                    Add User
                  </button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  
  data() {
    return {
      users: [],
      // eslint-disable-next-line no-undef
      form: new Form({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      })
    }
  },

  created() {
    // eslint-disable-next-line no-undef
    axios.get('/users').then(({ data }) => (this.users = data))
  },

  methods: {
    onSubmit() {
      this.form.password_confirmation = this.form.password // Temp for this form only.
      this.form.post('/users').then((user) => this.users.push(user))
    }
  }
}
</script>
