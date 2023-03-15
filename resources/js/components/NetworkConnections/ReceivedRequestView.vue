<template>
        <div class="my-2 shadow  text-white bg-dark p-1" id="">
        <div class="d-flex justify-content-between mb-2" v-for="(item, index) in received_requests">
          <table class="ms-1">
            <td class="align-middle">{{item.name}}</td>
            <td class="align-middle"> - </td>
            <td class="align-middle mt-2">{{item.email}}</td>
            <td class="align-middle"> </td>
          </table>
          <div>
            <button id="cancel_request_btn_" class="btn btn-primary me-1"  @click.prevent="AcceptRequest(item.id, index)">Accept</button>
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
    name: "ReceivedRequestView",
    data() {
        return {
          received_requests: [],
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
          axios.get('/api/user-connections/get-received-requests', {
            params: {
                'page': this.currentPage,
            }
          }).then(response => {
            console.log(response);
            this.received_requests = [...this.received_requests, ...response.data.received_requests.data];
            this.currentPage = response.data.received_requests.current_page;
            this.perPage = response.data.received_requests.per_page;
            this.total = response.data.received_requests.total;
            this.totalPages = response.data.received_requests.last_page;
          }).catch(error => {
            console.error("There was an error!", error);
          }).finally(() => {
          });
        },
        loadMoreData() {
            this.currentPage = this.currentPage + 1;
            this.getData();
        },
        AcceptRequest(id, index) {
            axios.post('/api/user-connections/accept-request',
            {
              id: id
            }
            ).then((response) => {
                this.received_requests.splice(index, 1);
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
