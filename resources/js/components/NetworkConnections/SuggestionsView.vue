<template>
<div class="my-2 shadow  text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between mb-2" v-for="(item, index) in suggestions">
    <table class="ms-1">
      <td class="align-middle">{{item.name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle mt-2">{{item.email}}</td>
      <td class="align-middle"> </td>
    </table>
    <div>
      <button id="create_request_btn_" class="btn btn-primary me-1"  @click.prevent="connectUser(item.id, index)">Connect</button>
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
    name: "SuggestionsView",
    data() {
        return {
          suggestions: [],
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
          axios.get('/api/user-connections/get-suggestions', {
            params: {
                'page': this.currentPage,
            }
          }).then(response => {
            console.log(response);
            this.suggestions = [...this.suggestions, ...response.data.suggestions.data];
            this.currentPage = response.data.suggestions.current_page;
            this.perPage = response.data.suggestions.per_page;
            this.total = response.data.suggestions.total;
            this.totalPages = response.data.suggestions.last_page;
          }).catch(error => {
            console.error("There was an error!", error);
          }).finally(() => {
          });
        },
        loadMoreData() {
            this.currentPage = this.currentPage + 1;
            this.getData();
        },
        connectUser(id, index) {
            axios.post('/api/user-connections/connect',
            {
              id: id
            }
            ).then((response) => {
                this.suggestions.splice(index, 1);
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
