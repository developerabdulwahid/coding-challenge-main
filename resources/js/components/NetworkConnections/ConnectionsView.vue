<template>

<div class="my-2 shadow text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between" v-for="(item, index) in connections">
    <table class="ms-1">
      <td class="align-middle">{{ item.name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ item.email }}</td>
      <td class="align-middle"></td>
    </table>
    <div>
      <button id="create_request_btn_" class="btn btn-danger me-1" @click.prevent="removeConnection(item.id, index)">Remove Connection</button>
    </div>
  </div>
        <template v-if="currentPage < totalPages">
        <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent">
                <button class="btn btn-primary" onclick="" id="load_more_btn" @click="loadMoreData()">Load more</button>
        </div>
      </template>
</div>
</template>

<script>
export default {
    name: "ConnectionsView",
    data() {
        return {
          connections: [],
          totalPages: 1,
          perPage: 0,
          total: 0,
          from: 0,
          to: 0,
          currentPage: 1,
          search_query: "",
        };
    },
    methods: {
        getData() {
          axios.get('/api/user-connections/get-connections', {
            params: {
                'page': this.currentPage,
            }
          }).then(response => {
            console.log(response);
            this.connections = [...this.connections, ...response.data.connections.data];
            this.currentPage = response.data.connections.current_page;
            this.perPage = response.data.connections.per_page;
            this.total = response.data.connections.total;
            this.totalPages = response.data.connections.last_page;
          }).catch(error => {
            console.error("There was an error!", error);
          }).finally(() => {
          });
        },
        loadMoreData() {
            this.currentPage = this.currentPage + 1;
            this.getData();
        },
        removeConnection(id, index) {
            axios.post('/api/user-connections/remove-connection',
            {
              id: id
            }
            ).then((response) => {
                this.connections.splice(index, 1);
                this.$swal({
                  icon: 'success',
                  title: response.data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
            }).catch((error) => {
              this.$swal({
                icon: 'error',
                title: 'Error',
                text: error.response.data.message,
              });
            });
        }
    },
    mounted() {
        this.getData();
    },
}
</script>
