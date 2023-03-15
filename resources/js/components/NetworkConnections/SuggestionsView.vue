<template>
<div class="my-2 shadow  text-white bg-dark p-1" id="">

  <div class="d-flex justify-content-between mb-2" v-for="(item, index) in suggestions">
  <div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow" style="height: 45px" v-if="loader==true">
    <strong class="ms-1 text-primary">Loading...</strong>
    <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
  </div>
    <table class="ms-1" v-if="loader==false">
      <td class="align-m iddle">{{item.name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle mt-2">{{item.email}}</td>
      <td class="align-middle"> </td>
    </table>
    <div  v-if="loader==false">
      <button id="create_request_btn_" class="btn btn-primary me-1"  @click.prevent="connectUser(item.id, index)">Connect</button>
    </div>
  </div>
  
      <template v-if="currentPage < totalPages && loader==false">
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
          loader: true,
        };
    },
    methods: {
        getData() {
            this.loader=true;
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
            this.loader=false;
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
