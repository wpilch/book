<?php
/**
 * ComponentManager component
 *
 * UI for the Vibrant Component Manager.
 *
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 *
 * @param array $components_by_type
 * @param string:json $components_json
 * @param string:json $components_paths_json Icon to open accordion
 */
?>

@bring('vue_component_manager')

<div id="componentsApp" >
    <template>
        <el-container class="main-container">
            <el-aside width="220px" style="
                            background-color: white;
                            height: 100%;
                            min-height: 500px;
                            overflow: hidden;
                            ">
                <el-container class="aside-container">
                    <el-header height="70px" style="position: absolute; z-index: 10; padding-right: 11px;">
                        <el-input prefix-icon="el-icon-search" placeholder="{{ucfirst(__('vibrant::shared.search'))}}" v-model="searchText"></el-input>
                    </el-header>
                    <el-menu :unique-opened="true" :default-active="currentComponentIndex" class="hidden-md-down" style="margin-top: 70px; overflow-y: auto; max-height: 640px">
                        @php $i = 1; @endphp
                        @foreach($components_by_type as $family=>$groups)
                        <el-submenu index="{{$i}}">
                            <template slot="title">{{ucfirst($family)}}</template>
                            @php $index = 1; @endphp
                            @foreach($groups as $group=>$components)
                            <el-menu-item-group>
                                <span slot="title" class="group-title">{{ $group }}</span>
                                @foreach($components as $component)
                                <el-menu-item @click="currentComponent = '{{$family.".".$component}}'" index="{{$i}}-{{$index}}">{{ucfirst($component)}}</el-menu-item>
                                @php $index++; @endphp
                                @endforeach
                            </el-menu-item-group>
                            @endforeach
                        </el-submenu>
                        @php $i++; @endphp
                        @endforeach
                    </el-menu>
                </el-container>
            </el-aside>
            <el-container class="content-container" v-bind:class="{'tip-panel': currentComponent.length == 0}">
                <div v-show="!showSearchResults" class="component-panel-wrapper">
                    <template v-if="currentComponent.length > 0" >
                        <el-container direction="vertical">
                            <el-header height="70px">
                                <h3 style="margin-top: 5px;margin-bottom: 0;">@{{ currentComponentInfo.name }}</h3>
                            </el-header>
                            <el-main v-loading="loading"
                                     element-loading-text="{{ucfirst(__('vibrant::shared.loading'))}}..."
                                     element-loading-background="rgba(255, 255, 255, 1)"
                                     element-loading-custom-class="component-loader"
                            >
                                <div class="container-overlay" v-if="loading"></div>
                                <template>
                                    <h4 style="font-weight: 300; font-size: 1.3rem"><span v-html="currentComponentInfo.description"></span></h4>
                                    <template v-for="link in currentComponentInfo.links">
                                        <el-button @click="openInNewTab(link.url)" size="medium" type="success" plain>@{{link.label}}</el-button>
                                    </template>
                                    <el-tabs value="first">
                                        <el-tab-pane label="Builder" name="first">
                                            <el-row :gutter="30">
                                                <el-col class="block-group" :md="24" :lg="8" style="min-width: 255px !important;">
                                                    <div class="block-title" @click="toggleBlock('parameters')" >
                                                        <i class="icon md-settings mr-5"></i>Parameters
                                                        <el-button v-if="showBlockParameters" @click.stop="updateAll" :loading="updating" type="primary" size="mini" style="float: right">Update</el-button>
                                                    </div>
                                                    <template v-if="showBlockParameters">
                                                        <div class="block-content">
                                                            <div v-show="!loading" v-for="param in currentComponentInfo.params" class="mb-10 parameter mx-10" v-bind:class="{ 'required': param.required  }">
                                                                <el-row :gutter="5">
                                                                    <el-col :span="22" >
                                                                        <span v-if="param.required" class="required-sign">*</span>
                                                                        <span class="param-label"> @{{ param.variable }}</span>
                                                                        <template v-if="param.input === '' || param.input === 'text' || param.input === 'textarea' ">
                                                                            <template v-if="param.validation === 'email' || param.validation === 'url'">
                                                                                <div class="param-input">
                                                                                    <el-input :placeholder="param.variable"
                                                                                              class="fw"
                                                                                              :type="param.validation"
                                                                                              v-model="dataParams[param.variable]"
                                                                                              size="small">
                                                                                    </el-input>
                                                                                </div>
                                                                            </template>
                                                                            <template v-else>
                                                                                <div class="param-input">
                                                                                    <el-input :placeholder="param.variable"
                                                                                              class="fw"
                                                                                              :type="param.input"
                                                                                              :rows="4"
                                                                                              v-model="dataParams[param.variable]"
                                                                                              size="small">
                                                                                    </el-input>
                                                                                </div>
                                                                            </template>
                                                                        </template>
                                                                        <template v-if="param.input === 'select'">
                                                                            <div class="param-input">
                                                                                <el-select v-model="dataParams[param.variable]"
                                                                                           :placeholder="param.variable"
                                                                                           class="fw"
                                                                                           size="small">
                                                                                    <el-option
                                                                                        v-for="item in param.options.split(',')"
                                                                                        :key="item"
                                                                                        :value="item">
                                                                                    </el-option>
                                                                                </el-select>
                                                                            </div>
                                                                        </template>
                                                                        <template v-if="param.input === 'number'">
                                                                            <div class="param-input">
                                                                                <el-input-number v-model="dataParams[param.variable]"
                                                                                                 controls-position="right"
                                                                                                 :min="parseInt(param.options.split(',')[0])"
                                                                                                 :max="parseInt(param.options.split(',')[1])"
                                                                                                 :step="parseInt(param.options.split(',')[2])"
                                                                                                 size="small">
                                                                                </el-input-number>
                                                                                <span class="param-units"> @{{ unitsForNumberData(param) }}</span>
                                                                            </div>

                                                                        </template>
                                                                        <template v-if="param.input === 'color'">
                                                                            <div class="param-input">
                                                                                <el-color-picker  v-model="dataParams[param.variable]"></el-color-picker >
                                                                            </div>
                                                                        </template>
                                                                        <template v-if="param.input === 'colorAlpha'">
                                                                            <div class="param-input">
                                                                                <el-color-picker show-alpha v-model="dataParams[param.variable]"></el-color-picker >
                                                                            </div>
                                                                        </template>
                                                                        <template v-if="param.input === 'switch'">
                                                                            <div class="param-input">
                                                                                <el-switch
                                                                                    :active-text="activeTextForSwitchData(param)"
                                                                                    :inactive-text="inactiveTextForSwitchData(param)"
                                                                                    v-model="dataParams[param.variable]">
                                                                                </el-switch >
                                                                            </div>
                                                                        </template>
                                                                    </el-col>
                                                                    <el-col :span="2">
                                                                        <template v-if="param.description.length > 0">
                                                                            <el-tooltip class="item" effect="dark" :content="param.description" placement="bottom-end">
                                                                                <i class="icon tip wb-info-circle"></i>
                                                                            </el-tooltip>
                                                                        </template>
                                                                    </el-col>
                                                                </el-row>
                                                            </div>
                                                        </div>
                                                        <div class="block-content" v-if="!loading && currentComponentInfo.meta.directive === 'component' && currentComponentInfo.slots.length > 0">
                                                            <h5 class="pl-10">Slots</h5>
                                                            <div v-for="slot in currentComponentInfo.slots" class="mb-10 parameter mx-10">
                                                                <el-row :gutter="5">
                                                                    <el-col :span="22" >
                                                                        <span class="param-label"> @{{ slot.label }}</span>
                                                                        <div class="param-input">
                                                                            <el-input :placeholder="slot.label"
                                                                                      class="fw"
                                                                                      type="textarea"
                                                                                      :rows="4"
                                                                                      v-model="dataParams['_slot_'+slot.label]"
                                                                                      size="small">
                                                                            </el-input>
                                                                        </div>
                                                                    </el-col>
                                                                    <el-col :span="2">
                                                                    </el-col>
                                                                </el-row>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </el-col>
                                                <el-col :md="24" :lg="16">
                                                    <div class="block-title" @click="toggleBlock('preview')">
                                                        <i class="icon md-flare mr-5"></i>Preview
                                                        <el-button v-if="showBlockPreview" @click.stop="isFullScreen = true" type="primary" size="mini" style="float: right">Full screen</el-button>
                                                    </div>
                                                    <template v-if="showBlockPreview">
                                                        <div v-bind:class="{ fullscreen: isFullScreen }" class="fluidMedia border-thick bg-bg">
                                                            <div class="loader loader-bounce" style="margin: 19% 45%"></div>
                                                            <iframe v-show="!loading" :src="frameSrc" :onload="frameLoaded()" frameborder="0" height="100%" width="100%"></iframe>
                                                        </div>
                                                    </template>

                                                    <div class="block-title" @click="toggleBlock('code')">
                                                        <i class="icon md-code mr-5"></i>Code
                                                        <el-button  v-if="showBlockCode"
                                                                    @click.stop
                                                                   v-clipboard:copy="code"
                                                                   v-clipboard:success="onCopyCode"
                                                                   type="primary" size="mini" style="float: right">Copy</el-button>
                                                    </div>
                                                    <template v-if="showBlockCode">
                                                        <div class="border-thin">
                                                            <codemirror v-model="code" :options="cmOption"></codemirror>
                                                        </div>
                                                    </template>
                                                </el-col>
                                            </el-row>
                                        </el-tab-pane>
                                    </el-tabs>
                                </template>
                            </el-main>
                        </el-container>
                    </template>
                    <template v-else>
                        <el-container direction="vertical">
                            <el-main>
                                <div class="select-component-tip text-center text-muted text-italic">
                                    <i class="icon wb-plugin font-size-60" aria-hidden="true"></i>
                                    <div class="icon-title font-size-24 mt-20" >{{ucfirst(__('vibrant::vibrant.select_component'))}}</div>
                                </div>
                            </el-main>
                        </el-container>
                    </template>
                </div>
                <div v-show="showSearchResults" class="search-wrapper">
                    <el-container>
                        <el-header height="70px">
                            <span class="title">{{__('vibrant::shared.search_results')}}</span>
                            <span class="close" @click="showSearchResults = false"><i class="icon wb-close"></i></span>
                        </el-header>
                        <el-main>
                            <template v-if="searchResults.length > 0">
                                <div class="list-group results-list">
                                    <a @click="currentComponent = item" @click="asideMenuCollapsed = true" class="list-group-item" v-for="item in searchResults">
                                        @{{ item }}
                                    </a>
                                </div>
                            </template>
                            <template v-else>
                                <p class="text-italic text-muted">{{__('vibrant::shared.no_results')}}</p>
                            </template>
                        </el-main>
                    </el-container>
                </div>
            </el-container>
        </el-container>
    </template>
    @component('vibrant::tools.layouts.sidebarRightModal',['modal_id' => 'components-right-drawer', 'modal_options' => 'data-backdrop=static data-keyboard=false', 'header_class' => 'block', 'body_class' => 'pb-0'])
        @slot('modal_header')
            <div class="modal-close-box">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-title-box">
                <h4 class="">{{ucfirst( __('vibrant::vibrant.components') )}}</h4>
            </div>
        @endslot
        @slot('modal_body')
                <div class="list-group">
                    @php $i = 1; @endphp
                    @foreach($components_by_type as $family=>$groups)
                        <h5 class="mb-2">{{ucfirst($family)}}</h5>
                        @php $index = 1; @endphp
                        @foreach($groups as $group=>$components)
                            <div>
                                <small class="px-15 text-mute">{{ $group }}</small>
                                @foreach($components as $component)
                                    <p class="list-group-item mb-1" data-dismiss="modal" @click="currentComponent = '{{$family.".".$component}}'">{{ucfirst($component)}}</p>
                                @endforeach
                            </div>
                        @endforeach
                        @php $i++; @endphp
                    @endforeach
                </div>
        @endslot

    @endcomponent()
</div>
@push('scripts')
    <script>
        Vue.use(VueCodemirror);
        ELEMENT.locale(ELEMENT.lang.en);
        new Vue({
            el: '#componentsApp',
            data: function(){
                return {
                    searchText: '',
                    showSearchResults: false,
                    searchResults: [],
                    componentsByType: [],
                    componentsPaths: [],
                    components: [],
                    componentHasIndex: [],
                    indexHasCategory: [],
                    currentComponent: '',
                    currentComponentIndex: '',
                    currentCategory: '',
                    currentPath: '',
                    currentComponentInfo: [],
                    dataParams: {},
                    variableBelongsToParameter: {},
                    asideMenuCollapsed: false,
                    code: '',
                    frameSrc: '',
                    loading: false,
                    updating: false,
                    isFullScreen: false,
                    cmOption: {
                        tabSize: 4,
                        readOnly: true,
                        lineNumbers: true,
                        mode: 'text/x-php',
                        theme: "monokai"
                    },
                    showBlockParameters: true,
                    showBlockPreview: true,
                    showBlockCode: true
                }
            },
            watch: {
                searchText: function (val) {
                    this.searchResults = [];
                    if(val.length > 0){
                        let self = this;
                        this.components.forEach(function(component){
                            if(component.toLowerCase().includes(val.toLowerCase())){
                                self.searchResults.push(component);
                            }
                        });
                        if(!this.showSearchResults){ this.showSearchResults = true }
                    }else{
                        if(this.showSearchResults){ this.showSearchResults = false }
                    }
                },
                currentComponent: function () {
                    //set active element in menu and all processes related to it
                    if(this.currentComponent !== ''){
                        this.loading = true;
                        this.resetComponent();
                        this.frameSrc = '';
                        this.currentComponentIndex = this.componentHasIndex[this.currentComponent];
                        this.currentCategory = this.indexHasCategory[this.currentComponent];
                        this.currentPath = this.componentsPaths[this.currentComponent];
                        // Get component info
                        let self = this;
                        axios.get('{{route('backend.components.getInfo')}}', {
                            params: {
                                blade_path: self.currentPath
                            }
                        })
                            .then(function (response) {
                                Vue.set(self, 'currentComponentInfo', response.data);
                                response.data.params.forEach(function(param, index){
                                    if(param.input === 'switch'){
                                        let boolValue = (param.example == '1' || param.example == 'true' ) ? true : false;
                                        Vue.set(self.dataParams, param.variable, boolValue);
                                    }else{
                                        Vue.set(self.dataParams, param.variable, param.example);
                                    }
                                    Vue.set(self.variableBelongsToParameter, param.variable, index);
                                });
                                self.currentComponentInfo.slots.forEach(function(slot, index){
                                    Vue.set(self.dataParams, '_slot_'+slot.label, slot.content);
                                });
                                self.updateAll();
                            })
                            .catch(function (error) {
                                //console.log(error);
                            });
                    }else{
                        this.currentComponentIndex = '';
                        this.currentCategory = '';
                        this.currentPath = '';
                        this.code = '';
                        this.frameSrc = '';
                        this.currentComponentInfo = [];
                        this.setShowBlockStatus();
                    }
                    //clear search
                    this.searchText= '';
                    if(this.showSearchResults){ this.showSearchResults = false }
                },
                isFullScreen: function(val){
                    if(val === true){
                        let self = this;
                        this.$message({
                            message: 'Press ESC or close me',
                            showClose: true,
                            center: true,
                            duration: 0,
                            customClass: 'fullScreenTip',
                            onClose: function(){
                                self.isFullScreen = false;
                            }
                        });
                    }
                },
            },
            methods:{
                updateAll: function(){
                    this.updating = true;
                    this.updateFrame();
                    this.updateCode();
                },
                updateCode: function(){
                    let info = this.currentComponentInfo;
                    let paramsCode = '';
                    let slotsCode = '';
                    let required_flag = false;
                    let optional_flag = false;
                    let self = this;
                    info.params.forEach(function(param, idx, array){
                        let units = self.unitsForNumberData(param);
                        if(param.required){
                            if(!required_flag){
                                paramsCode += `    `+`//required parameters:\n`;
                            }
                            if (Object.is(array.length - 1, idx)) {
                                if(param.type === 'bool'){
                                    paramsCode += `    `+`'`+param.variable+`' => `+self.dataParams[param.variable]+units+`\n`;
                                }else{
                                    paramsCode += `    `+`'`+param.variable+`' => '`+self.dataParams[param.variable]+units+`'\n`;
                                }
                            }else{
                                if(param.type === 'bool'){
                                    paramsCode += `    `+`'`+param.variable+`' => `+self.dataParams[param.variable]+units+`,\n`;
                                }else{
                                    paramsCode += `    `+`'`+param.variable+`' => '`+self.dataParams[param.variable]+units+`',\n`;
                                }

                            }
                            required_flag = true;
                        }else{
                            if(!optional_flag){
                                paramsCode += `    `+`//optional parameters:\n`;
                            }
                            let commentOut = '';
                            if(self.dataParams[param.variable].length === 0 || (self.dataParams[param.variable]+units).toString() === param.default){
                                commentOut =  '//';
                                units = '';
                            }
                            if((self.dataParams[param.variable]+units).toString() === param.default){
                                commentOut =  '//';
                            }
                            if (Object.is(array.length - 1, idx)) {
                                if(param.type === 'bool'){
                                    paramsCode += `    `+commentOut+`'`+param.variable+`' => `+self.dataParams[param.variable]+units+`\n`;
                                }else{
                                    paramsCode += `    `+commentOut+`'`+param.variable+`' => '`+self.dataParams[param.variable]+units+`'\n`;
                                }
                            }else{
                                if(param.type === 'bool'){
                                    paramsCode += `    `+commentOut+`'`+param.variable+`' => `+self.dataParams[param.variable]+units+`,\n`;
                                }else{
                                    paramsCode += `    `+commentOut+`'`+param.variable+`' => '`+self.dataParams[param.variable]+units+`',\n`;
                                }
                            }
                            optional_flag = true;
                        }
                    });
                    if(info.meta.alias != null && info.meta.alias.length > 0){
                        this.code = '@verbatim@'+
                            info.meta.alias+`([\n`+paramsCode+`])\n`+slotsCode+`\n@end`+info.meta.alias+`@endverbatim`;
                        return false;
                    }
                    if(info.meta.directive === 'include'){
                        this.code = '@verbatim@'+
                            info.meta.directive+`('`+this.currentPath+`', [\n`+paramsCode+`])@endverbatim`;
                        return false;
                    }
                    if(info.meta.directive === 'component'){
                        info.slots.forEach(function(slot){
                            if(slot.label === 'default'){
                                ( self.dataParams['_slot_'+slot.label].length > 0 ) ? slotsCode += '    '+self.dataParams['_slot_'+slot.label] : slotsCode += '    //Your default slot content here';
                            }else{
                                ( self.dataParams['_slot_'+slot.label].length > 0 ) ? slotsCode += '\n'+"    @verbatim@slot('"+ slot.label + "')" + '\n        '+self.dataParams['_slot_'+slot.label] +'    @endslot' : slotsCode += '\n    //'+"@slot('"+ slot.label + "')@endslot@endverbatim";
                            }
                        });
                        this.code = '@verbatim@'+
                            info.meta.directive+`('`+this.currentPath+`', [\n`+paramsCode+`])\n`+slotsCode+`\n@endcomponent`+`@endverbatim`;

                    }
                },
                updateFrame: function(){
                    let processedData = {};
                    let self = this;
                    let variables = Object.getOwnPropertyNames(this.dataParams);
                    delete variables[0];
                    variables.forEach(function(variable){
                        let paramIndex = self.variableBelongsToParameter[variable];
                        let param = self.currentComponentInfo.params[paramIndex];
                        let units = self.unitsForNumberData(param);
                        processedData[variable] = self.dataParams[variable].toString()+units;
                    });
                    let jsonParams = encodeURIComponent(JSON.stringify(processedData));
                    this.frameSrc = '/backend/components/preview?blade_path='+this.currentPath+'&params='+jsonParams;
                    return false;
                },
                frameLoaded: function() {
                    if(this.frameSrc.length > 0){
                        let self = this;
                        setTimeout(function(){
                            self.loading = false;
                            self.updating = false;
                        }, 1500);
                    }
                },
                onCopyCode: function(){
                    this.$message({
                        message: 'Code was copied to clipboard.',
                        type: 'success'
                    });
                },
                unitsForNumberData: function(param) {
                    if ( param == null || !param.hasOwnProperty('input') || param.input !== 'number'){
                        return '';
                    }else{
                        let options = param.options.split(',');

                        if (options[3] == null) {
                            return ''
                        }else{
                            return options[3];
                        }
                    }
                },
                activeTextForSwitchData: function(param){
                    if ( param == null || !param.hasOwnProperty('input') || param.input !== 'switch' || param.options === ''){
                        return '';
                    }else{
                        let options = param.options.split(',');
                        if (options[0] == null) {
                            return ''
                        }else{
                            return options[0];
                        }
                    }
                },
                inactiveTextForSwitchData: function(param){
                    if ( param == null || !param.hasOwnProperty('input') || param.input !== 'switch' || param.options === ''){
                        return '';
                    }else{
                        let options = param.options.split(',');
                        if (options[1] == null) {
                            return ''
                        }else{
                            return options[1];
                        }
                    }
                },
                resetComponent: function() {
                    this.currentComponentIndex = '';
                    this.currentCategory = '';
                    this.currentPath = '';
                    this.currentComponentInfo = [];
                    this.dataParams = {};
                    this.variableBelongsToParameter = {};
                    this.setShowBlockStatus()
                },
                goTo: function(url){
                    window.location.href = url;
                },
                openInNewTab: function(url) {
                    var win = window.open(url, '_blank');
                    win.focus();
                },
                toggleBlock: function(block){
                    switch(block){
                        case 'parameters':
                            this.showBlockParameters = !this.showBlockParameters;
                            break;
                        case 'preview':
                            this.showBlockPreview = !this.showBlockPreview;
                            break;
                        case 'code':
                            this.showBlockCode = !this.showBlockCode;
                            break;
                    }
                },
                setShowBlockStatus: function(){
                    if(window.innerWidth < 992){
                        this.showBlockParameters = false;
                        this.showBlockPreview = true;
                        this.showBlockCode = false;
                    }else{
                        this.showBlockParameters = true;
                        this.showBlockPreview = true;
                        this.showBlockCode = true;
                    }
                }
            },
            mounted() {
                this.componentsByType = JSON.parse('{!! $components_json !!}');
                this.componentsPaths = JSON.parse('{!! $components_paths_json !!}');
                let self = this;
                let menu_count = 1;
                Object.keys(this.componentsByType).forEach(function(family){
                    let submenu_count = 1;
                    Object.keys(self.componentsByType[family]).forEach(function(group){
                        self.componentsByType[family][group].forEach(function(component){
                            (self.components).push(family+'.'+component);
                            //set has index
                            let index =menu_count.toString()+'-'+submenu_count.toString();
                            self.componentHasIndex[family+'.'+component] = index;
                            submenu_count ++;
                            //set has category
                            self.indexHasCategory[index] = family;
                        });
                    });
                    menu_count++;
                });
                //Handle key downs
                document.onkeydown = function(evt) {
                    evt = evt || window.event;
                    if (evt.keyCode === 27) {
                        self.isFullScreen = false;
                        self.$message.closeAll();
                    }
                };
                //Handle show
                @if(!empty($show))
                    if(this.components.includes('{{$show}}')){
                        this.currentComponent = '{{$show}}';
                    }
                @endif
            }
        })
    </script>
    <script>
        jQuery('#action-open-right-drawer').click(function(){
            openLeftDrawer();
        });
        function openLeftDrawer(){
            jQuery('#components-right-drawer').modal('show');
        }
    </script>
@endpush

