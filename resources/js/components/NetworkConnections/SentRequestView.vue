<template>
    <div class="my-2 shadow  text-white bg-dark p-1" id="">
        <div class="d-flex justify-content-between mb-2" v-for="(item, index) in sent_requests">
          <table class="ms-1">
            <td class="align-middle">{{item.name}}</td>
            <td class="align-middle"> - </td>
            <td class="align-middle mt-2">{{item.email}}</td>
            <td class="align-middle"> </td>
          </table>
          <div>
            <button id="cancel_request_btn_" class="btn btn-danger me-1"  @click.prevent="withdrawRequest(item.id, index)">Withdraw request</button>
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
    name: "SentRequestView",
    data() {
        return {
          sent_requests: [],
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
          axios.get('/api/user-connections/get-sent-requests', {
            params: {
                'page': this.currentPage,
            }
          }).then(response => {
            console.log(response);
            this.sent_requests = [...this.sent_requests, ...response.data.sent_requests.data];
            this.currentPage = response.data.sent_requests.current_page;
            this.perPage = response.data.sent_requests.per_page;
            this.total = response.data.sent_requests.total;
            this.totalPages = response.data.sent_requests.last_page;
          }).catch(error => {
            console.error("There was an error!", error);
          }).finally(() => {
          });
        },
        loadMoreData() {
            this.currentPage = this.currentPage + 1;
            this.getData();
        },
        withdrawRequest(id, index) {
            axios.post('/api/user-connections/withdraw-request',
            {
              id: id
            }
            ).then((response) => {
                this.sent_requests.splice(index, 1);
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
