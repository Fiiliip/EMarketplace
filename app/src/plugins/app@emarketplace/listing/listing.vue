<template>
    <div class="mx-5 my-5">
        <div class="h-full flex flex-col md:flex-row">
            <div class="w-full h-full px-2">
                <!-- Selected Image -->
                <div>
                    <img v-if="selectedImage" :src="selectedImage.url" :alt="listing.title" class="xs:h-64 mx-auto" />
                    <div v-else class="skelet xs:h-64 mx-auto"></div>
                </div>
                <!-- Other Images -->
                <div v-if="listing?.images" class="flex mt-2 gap-2 flex-wrap">
                    <img @click="selectedImage = image" v-for="image in listing.images" :key="image.id" :src="image.url" :class="{'opacity-70': image == selectedImage}" class="h-20 sm:h-24 cursor-pointer">
                </div>
                <!-- TODO: Remove or make it better. It looks awful. -->
                <!-- <div v-else class="flex mt-2 gap-2 flex-wrap">
                    <div v-for="skeletImageIdx in 8" :key="`skeletImageIdx-${skeletImageIdx}`" class="skelet h-20 w-[96px] sm:h-24"></div>
                </div> -->
            </div>
            <div class="w-full md:w-[75%] lg:w-full h-full px-2 mt-5 md:mt-0">
                <h3 v-if="listing?.title" class="text-lg font-semibold">{{ listing.title }}</h3>
                <div v-else class="skelet h-7 w-2/3"></div>
                <p v-if="listing?.price" class="mt-2">Cena: <span v-if="listing?.price" class="font-medium">{{ getFormattedPrice(listing.price) }}</span></p>
                <p v-else class="skelet h-6 w-2/6 mt-2"></p>
                <div v-if="listing?.author.contact" class="mt-2">
                    <h4 class="font-medium">Kontakt</h4>
                    <p class="text-sm">Meno: <a href="#" class="font-medium hover:text-zinc-400">{{ listing.author.name }}</a></p>
                    <p class="text-sm">Email: <a :href="`mailto:${listing.author.contact.email}`" class="hover:text-zinc-400">{{ listing.author.contact.email }}</a></p>
                    <p v-if="listing?.author.contact.phone" class="text-sm">Telefón: <a :href="`tel:${listing.author.contact.phone}`" class="hover:text-zinc-400">{{ listing.author.contact.phone }}</a></p>
                </div>
                <div v-else class="skelet h-20 w-full mt-2"></div>
                <div class="flex mt-3 items-center justify-between">
                    <a v-if="listing?.location" :href="`http://maps.google.com/?q=${listing.location}`" target="_blank" class="h-5 flex flex-row items-center hover:text-zinc-400 bg-zinc-200 px-2 py-1 mr-1 rounded">
                        <img class="h-3.5 w-3.5 mt-[1px] mx-auto" src="@/plugins/app/_assets/_icons/location.svg" alt="location"/>
                        <p class="ml-1.5 text-sm">{{ listing.location }}</p>
                    </a>
                    <a v-else class="skelet h-5 w-1/4"></a>
                    <div class="flex items-center">
                        <div v-if="listing?.views" class="h-5 flex flex-row items-center bg-zinc-200 px-2 py-1 mr-1 rounded">
                            <img class="h-4 w-4 mt-[2px] mx-auto" src="@/plugins/app/_assets/_icons/eye.svg" alt="views"/>
                            <p class="ml-1.5 text-sm">{{ listing.views }}</p>
                        </div>
                        <div v-else class="skelet h-5 w-[50px] mr-1"></div>
                        <div v-if="listing?.created_at" class="h-5 flex flex-row items-center bg-zinc-200 px-2 py-1 mr-1 rounded">
                            <img class="h-4 w-4 mt-[1px] mx-auto" src="@/plugins/app/_assets/_icons/calendar.svg" alt="date"/>
                            <p class="ml-1.5 text-sm">{{ getFormattedDate(listing.created_at) }}</p>
                        </div>
                        <div v-else class="skelet h-5 w-[60px]"></div>
                    </div>
                </div>

                <div v-if="listing?.description" class="mt-2 text-sm">{{ listing.description }}</div>
                <div v-else class="skelet h-60 w-full mt-2"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            listing: null,
            selectedImage: null,
        }
    },

    async mounted() {
        this.listing = await this._getListing(this.$route.params.id)
        this.selectedImage = this.listing.images[0]
    }
}
</script>