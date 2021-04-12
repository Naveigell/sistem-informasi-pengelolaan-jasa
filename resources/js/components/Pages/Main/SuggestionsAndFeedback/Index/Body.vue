<template>
    <div class="app-container">
        <div style="margin: 20px;">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="elevation-2" style="background: white;">
                        <div style="background-color: #f6f7f8; height: 60px; font-family: InterRegular, Arial, sans-serif;">
                            <div style="padding-left: 25px; padding-right: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <h5 style="font-weight: 500; letter-spacing: 1px; line-height: 40px; font-size: 16px;">SUGGESTIONS</h5>
                                <div style="font-size: 16px;">
                                    <span style="display: inline-block; padding: 5px 10px; border-radius: 3px; background: #e0e5e8; cursor: pointer;"><i class="fa fa-refresh"></i></span>
                                    <router-link :to="{ path: '/orders/add' }" style="display: inline-block; padding: 5px 10px; border-radius: 3px; background: #e0e5e8; cursor: pointer; color: #000">
                                        <i class="fa fa-plus"></i>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px; min-height: 300px;">
                            <div v-for="i in 9" style="margin-bottom: 25px;">
                                <div style="background-color: #e9ecef; height: 45px; display: flex; align-items: center; padding: 14px;">
                                    <span style="color: #5179d6; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">Perbaikan sangat rapi</span>
                                    <span style="color: #818181; font-family: InterRegular, Arial, sans-serif; font-weight: bold;">,</span>
                                    <span style="color: #818181; font-family: InterRegular, Arial, sans-serif; font-style: italic;">&nbsp July 20, 2019 20:29</span>
                                </div>
                                <div style="font-family: InterRegular, Arial, sans-serif;">
                                    <div style="padding: 10px;" class="content">
                                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    </div>
                                    <hr>
                                    <p class="font-size-sm text-muted">Strive not to be a success, but rather to be of value.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Test from "../../../../Test";
export default {
    name: "Body",
    components: {Test}
}
</script>

<style scoped>
.content > * {
    font-family: InterRegular, Arial, sans-serif;
    line-height: 1.6;
}
</style>
