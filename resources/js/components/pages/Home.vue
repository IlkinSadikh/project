<template>
	<div>
		<div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">News</p>
                    <Input style='margin: 5px' search v-model="search" placeholder="Search by category" /></p>

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
							<tr v-for="(article, index) in filteredArticles" :key="index" v-if="articles.length">
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
                    title="Article"
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
            showModal : false,
            articles: [],
            showData : {
                title : '',
				category : '',
				description : '',
            },
            search: '',
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

    computed: {
        filteredArticles: function(){
            return this.articles.filter((article) => {
                return article.category.match(this.search)
            })
        }
    },
}
</script>
