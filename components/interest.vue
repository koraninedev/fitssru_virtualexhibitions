<template>
    <div class="card shadow-sm border-0 h-100">
        <!-- <a :href="`blog/${blog.url}`"> -->
        <a :href="currentUrl.includes('pic') ? `pic/${blog.blog_id}-${blog.url}`
                 : currentUrl.includes('3d') ? `3d/${blog.blog_id}-${blog.url}`
                 : currentUrl.includes('video') ? `video/${blog.blog_id}-${blog.url}`
                 : `./`">
            <img :src="currentUrl.includes('pic') ? `assets/pictures/${blog.branch_name}/thumbnails/${blog.image}`
                        : currentUrl.includes('3d') ? `assets/3dmodels/${blog.branch_name}/thumbnails/${blog.image}`
                        : currentUrl.includes('video') ? `assets/videos/${blog.branch_name}/thumbnails/${blog.image}`
                        : `./`" class="card-img-top" alt="${blog.image}" style="height: 300px; width: 100%; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column">
            <p class="card-title fw-bold lh-base">{{ blog.subject}}</p>
            <p class="small">{{ blog.subtitle}}</p>
            <div class="mt-auto">
                <div class="d-grid mt-2">
                    {{branch_name}}
                    <!-- <a :href="`blog/${blog.url}`" class="btn btn-warning fw-bold"> -->
                    <a :href="currentUrl.includes('pic') ? `pic/${blog.blog_id}-${blog.url}`
                        : currentUrl.includes('3d') ? `3d/${blog.blog_id}-${blog.url}`
                        : currentUrl.includes('video') ? `video/${blog.blog_id}-${blog.url}`
                        : `./`" class="btn btn-danger text-white">
                        อ่านเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
module.exports = {
    props:['blog', 'branch_name'],
    components: {
        'star-component': httpVueLoader('./star.vue')
    },
    methods: {
        getRating (current) {
            return (current / 5) * 100
        }
    },
    mounted() {
        /* console.log(this.branch_name) */
    },
    computed: {
        currentUrl() {
            return window.location.href;
        }
    }
}
</script>

<style scoped>
</style>