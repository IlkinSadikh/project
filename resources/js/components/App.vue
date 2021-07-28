<template>
    <div id="app">
        <div>
            <!--========== SIDE MENU one ========-->
            <div class="_1side_menu" >
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <div class="_1side_menu_list">
            <ul class="_1side_menu_list_ul">
              <li><router-link to="/"><Icon type="ios-paper" />News</router-link></li>
              <li><router-link to="/manager"><Icon type="md-build" />Manager</router-link></li>
            </ul>
          </div>
            </div>
        </div>
    	<router-view/>
    </div>
</template>
