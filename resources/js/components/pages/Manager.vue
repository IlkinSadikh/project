<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-12">
						<div class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_one">
							<div class="_1adminOverveiw_card_left">
								<p class="_1adminOverveiw_card_left_num">{{ articles.length }}</p>

								<p class="_1adminOverveiw_card_left_title">Articles</p>
							</div>
							<div class="_1adminOverveiw_card_right">
								<Icon type="ios-paper" />
							</div>
						</div>
					</div>
				</div>

				<!-- TABLE -->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">News <Button @click="addModal=true">Add Article<Icon type="md-add" /></Button></p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Category</th>
                                <th>Description</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(article, index) in articles" :key="index" v-if="articles.length">
								<td>{{ article.id }}</td>
								<td>{{ article.title }}</td>
								<td>{{ article.category }}</td>
                                <td>{{ article.description }}</td>
								<td>
									<Button type="primary" size='small' @click="showArticle(article, index)">View</Button>
									<Button type="success" size='small' @click="showEditModal(article, index)">Edit</Button>
									<Button type="error" size='small' @click="showDeletingModal(article, index)" :loading="article.isDeleting">Delete</Button>
								</td>
							</tr>
                                <!-- ITEMS -->
						</table>
					</div>
				</div>
                <!-- TABLE -->

                <!-- ARTICLE ADDING MODAL -->
                <Modal
                    v-model="addModal"
                    title="Add article"
                    :mask-closable = 'false'
                    :closable = 'false'
                    >

                    <div>Add title :</div>
                        <Input v-model="data.title" placeholder="Add title" />
                    <div style="margin-top: 5px">Add category :</div>
                        <Input v-model="data.category" placeholder="Add category" />
                    <div style="margin-top: 5px">Add description :</div>
                        <Input v-model="data.description" type="textarea" :rows="4" placeholder="Add description" />
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addArticle" :disabled="isAdding" :loading="isAdding">
                        {{ isAdding ? 'Adding' : 'Add Article'}}</Button>
                    </div>

                </Modal>
                <!-- ARTICLE ADDING MODAL -->

                <!-- ARTICLE EDITING MODAL -->
                <Modal
                    v-model="editModal"
                    title="Edit article"
                    :mask-closable = 'false'
                    :closable = 'false'

                    >
                    <div>Add title :</div>
                        <Input v-model="editData.title" placeholder="Add title" />
                    <div style="margin-top: 5px">Add category :</div>
                        <Input v-model="editData.category" placeholder="Add category" />
                    <div style="margin-top: 5px">Add description :</div>
                        <Input v-model="editData.description" type="textarea" :rows="4" placeholder="Add description" />
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editArticle" :disabled="isAdding" :loading="isAdding">
                        {{ isAdding ? 'Editing' : 'Edit Article'}}</Button>
                    </div>

                </Modal>
                <!-- ARTICLE EDITING MODAL -->

                <!-- DELETE ALERT MODAL -->
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete this article?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"
                        @click="deleteArticle">Delete</Button>
                    </div>
                </Modal>
                <!-- DELETE ALERT MODAL -->

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
        async addArticle(){
            if(this.data.title.trim() == '') return this.e('Title is required')
            if(this.data.category.trim() == '') return this.e('Category is required')
            if(this.data.description.trim() == '') return this.e('Description is required')
            const res = await this.callApi('post', '/app/create_article', this.data)
            if(res.status === 201){
                this.articles.unshift(res.data)
                this.s('Article added successfully')
                this.addModal = false
                this.data.title = ''
                this.data.category = ''
                this.data.description = ''
            }else{
                if(res.status==422){
                    if(res.data.errors.title){
                        this.e(res.data.errors.title[0])
                    }
                    if(res.data.errors.category){
                        this.e(res.data.errors.category[0])
                    }
                    if(res.data.errors.description){
                        this.e(res.data.errors.description[0])
                    }
                }else{
                    this.swr()
                }
            }
        },

        async editArticle(){
            if(this.editData.title.trim()=='') return this.e('article name is required')
            if(this.editData.category.trim() == '') return this.e('Category is required')
            if(this.editData.description.trim() == '') return this.e('Description is required')
            const res = await this.callApi('post', 'app/edit_article', this.editData)
            if(res.status===200){
                this.articles[this.index].title = this.editData.title
                this.s('Article has been edited successfully')
                this.editModal = false
            }else{
                if(res.status==422){
                    if(res.data.errors.title){
                        this.e(res.data.errors.title[0])
                    }
                    if(res.data.errors.category){
                        this.e(res.data.errors.category[0])
                    }
                    if(res.data.errors.description){
                        this.e(res.data.errors.description[0])
                    }
                }else{
                    this.swr()
                }
            }
        },

        showEditModal(article, index){
            let obj = {
                id : article.id,
                title : article.title,
                category : article.category,
                description : article.description
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        async deleteArticle(){
            this.isDeleting = true
            const res = await this.callApi('post', 'app/delete_article', this.deleteItem)
            if(res.status===200){
                this.articles.splice(this.deletingIndex, 1)
                this.s('Article has been successfully deleted')
            }else{
                this.swr()
            }
            this.isDeleting = false
            this.showDeleteModal = false
        },

        showDeletingModal(article, i){
            this.deleteItem = article
            this.deletingIndex = i
            this.showDeleteModal = true
        },

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
