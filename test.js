<!-- <td>
<button class="btn btn-sm btn-primary" @click.prevent="connectUser(item.id, index)">Connect</button>
</td> -->
</tr>
    <template v-if="currentPage < totalPages">
    <tr style="text-align: center;">
    <td colspan="2">
        <button 
            class="btn btn-sm btn-primary"
            @click="loadMoreData()"
        >
            Load more
        </button>
    </td>
    </tr>
    </template>