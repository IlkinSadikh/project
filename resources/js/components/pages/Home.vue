<template>
	<div>
		<div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Recent News</p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Title</th>
								<th>Category</th>
                                <th>Description</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(article, index) in articles" :key="index" v-if="articles.length">
								<td>{{ article.title }}</td>
								<td>{{ article.category }}</td>
                                <td>{{ article.description }}</td>
								<td>
									<Button type="primary" @click="showArticle(article, index)">View Article</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>

                <!-- SHOW ARTICLE MODAL -->
                <Modal
                    v-model="showModal"
                    width="720"
                    title="Add article"
                    :mask-closable = 'false'
                    :closable = 'false'

                    >
                        <h1>{{ showData.title }}</h1>
                    <div style="margin-top: 5px"></div>
                        <h3>{{ showData.category }}</h3>
                    <div style="margin-top: 5px"></div>
                        <p>{{ showData.description }}</p>
                    <div slot="footer">
                        <Button type="default" @click="showModal=false">Close</Button>
                    </div>

                </Modal>
                <!-- SHOW ARTICLE MODAL -->

			</div>
		</div>
	</div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                title : '',
				category : '',
				description : '',
            },
            addModal : false,
            editModal : false,
            showModal : false,
            isAdding : false,
            articles: [],
            editData : {
                title : '',
				category : '',
				description : '',
            },
            showData : {
                title : '',
				category : '',
				description : '',
            },
            index : -1,
            showDeleteModal: false,
            isDeleting : false,
            deleteItem: {},
            deletingIndex: -1,
            token: '',
        }
    },

    methods: {
        showArticle(article, index){
            let obj = {
                id : article.id,
                title : article.title,
                category : article.category,
                description : article.description
            }
            this.showData = obj
            this.showModal = true
            this.index = index
        }
    },

    async created() {
        const res = await this.callApi('get', '/app/get_articles')
        if(res.status==200){
            this.articles = res.data
        }else{
            this.swr()
        }
    },
}
</script>
