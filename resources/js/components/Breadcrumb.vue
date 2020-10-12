<template>
    <b-breadcrumb :items="crumbs"></b-breadcrumb>
</template>

<script>
    export default {
        name: "Breadcrumb",
        computed: {
            crumbs: function () {
                let pathArray = this.$route.path.split("/")
                pathArray.shift();
                return pathArray.reduce((breadcrumbArray, path, idx) => {
                    let breadcrumb = this.$route.matched[idx];
                    let text = path;
                    if (breadcrumb && breadcrumb.meta) {
                        text = breadcrumb.meta.breadcrumb ? breadcrumb.meta.breadcrumb : breadcrumb.name;
                    } else if (breadcrumb) {
                        text = breadcrumb.name;
                    }
                    // let text = (this.$route.matched[idx] && this.$route.matched[idx].meta && this.$route.matched[idx].meta.breadcrumb ? this.$route.matched[idx].meta.breadcrumb : this.$route.matched[idx].name) || path;
                    breadcrumbArray.push({
                        path: path,
                        to: breadcrumbArray[idx - 1]
                            ? "/" + breadcrumbArray[idx - 1].path + "/" + path
                            : "/" + path,
                        text: text
                    });
                    return breadcrumbArray;
                }, []);
            }
        }
    }
</script>
