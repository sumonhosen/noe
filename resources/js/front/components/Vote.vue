<template>
    <div class="card mb-4">
        <div class="card-header card-img-wrap">
            <img :src="img_path" width="100%" :alt="vote.title">
        </div>

        <div class="modal-body">
            <div class="text-center">
                <i class=" fa-4x mb-3 text-primary"></i>
                <div v-html="vote.short_description"></div>
            </div>
            <hr >
            <form class="px-4" action="javascript:void(0)" ref="vote_form">
                <input type="hidden" :value="vote.id" name="vote_id">
                <div class="form-check mb-2" id="comment_div">
                    <div class="col-md-12">
                        <input v-if="is_vote" class="form-check-input" type="radio" v-model="q_answer" disabled  name="answer" value="Yes" id="radio3Example1" >
                        <input v-else class="form-check-input" type="radio" v-model="q_answer"  name="answer" value="Yes" id="radio3Example1" >
                        <label class="form-check-label" for="radio3Example1">
                            Yes
                        </label>
                        <span class="float-right">{{votePercentage('Yes')}}%</span>
                    </div>
                </div>
                <div class="form-check mb-2" id="comment_div">
                    <div class="col-md-12">
                        <input class="form-check-input" v-if="is_vote" type="radio" name="answer" disabled v-model="q_answer" value="No" id="radio3Example2" >
                        <input class="form-check-input" v-else type="radio" name="answer" v-model="q_answer" value="No" id="radio3Example2" >
                        <label class="form-check-label" for="radio3Example2">
                            No
                        </label>
                        <span class="float-right">{{votePercentage('No')}}%</span>
                    </div>
                </div>
                <div class="form-check mb-2" id="comment_div">
                    <div class="col-md-12">
                        <input class="form-check-input" v-if="is_vote" type="radio" value="No Comments" disabled v-model="q_answer" name="answer" id="radio3Example3" >
                        <input class="form-check-input" v-else type="radio" value="No Comments" v-model="q_answer" name="answer" id="radio3Example3" >
                        <label class="form-check-label" for="radio3Example3">
                            No Comments
                        </label>
                        <span class="float-right">{{votePercentage('No Comments')}}%</span>
                    </div>
                </div>
                <div class="form-check mb-2 pl-0 d-inline-block">
                    <button v-if="is_vote" type="button" @click="changeVote()" class="animated-button6 bt_back nav">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Change Vote
                    </button>
                    <button v-else type="submit" @click="submitForm()" class="animated-button6 bt_back nav">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Vote
                    </button>
                </div>

                <a v-if="!all_page" :href="app_url+'/vote/all'" class="button tn_load_more_btn button_view_all mt-0 float-right">View All</a>
            </form>
        </div>
    </div>
</template>
<script>
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
import { BButton,BSpinner  } from 'bootstrap-vue'
import Vue from "vue";
Vue.use(Toaster, {timeout: 5000})
import axios from "axios";
export default {
    name:'Vote',
    props:{
        app_url:{
            required:true,
        },
        vote:{
            required: true,
            type:Object,
        },
        img_path:{
            required:false
        },
        answers:{
            required:true,
        },
        user_id:{
            required:false,
        },
        ip:{
            required:true,
        },
        all_page:{
            required:false,
        }
    },
    components:{
        BButton,BSpinner
    },
    data(){
        return{
            answer:[],
            is_loading:false,
            is_vote:false,
            q_answer: null,
        }
    },
    created() {
        this.answer=this.answers;
        this.isVote();
    },
    methods:{
        async submitForm(){
            this.is_loading=true;
            let data =new FormData(this.$refs.vote_form);
            await axios.post(`${this.app_url}/vote/store`,data).then((response)=>{
                this.is_loading=false;
                this.is_vote=true;
                this.$toaster.success(response.data.message);
                this.addVote();//update current vote
            }).catch((error)=>{
                this.is_loading=false;
                if (error.response.status === 422) {
                    Object.keys(error.response.data.errors).map((field) => {
                        this.$toaster.error(error.response.data.errors[field][0]);
                    });
                } else this.$toaster.error(error.response.data.message);
            })
        },
        addVote(){
          let vt = this.jsonDecode(this.answer);
          let index = vt.findIndex(item=>parseInt(item.user_id)===parseInt(this.user_id) && parseInt(item.vote_id)===parseInt(this.vote.id));
          if (index>=0){
              vt[index].answer=this.q_answer;
              vt[index].ip=this.ip;
          }else{
              vt.push(
                  {
                      "user_id":this.user_id,
                      "vote_id":this.vote.id,
                      "vote_question_id":null,
                      "answer":this.q_answer,
                      "ip":this.ip,
                  }
              );
          }
          this.answer=JSON.stringify(vt);
        },
        jsonDecode(data){
            try{
                return JSON.parse(data);
            }catch ($e){
                return data
            }
        },
        changeVote(){
          this.is_vote=false;
        },
        isVote(){
            if (this.user_id){
                var dd = this.jsonDecode(this.answer).map((item)=>{
                    if (parseInt(item.vote_id)===parseInt(this.vote.id) && parseInt(item.user_id)===parseInt(this.user_id)) return item;
                }).filter(Boolean);
            }else{
                var dd = this.jsonDecode(this.answer).map((item)=>{
                    if (parseInt(item.vote_id)===parseInt(this.vote.id) && item.ip=== this.ip) return item;
                }).filter(Boolean);
            }
            if (dd.length>0){
                this.q_answer = dd[0].answer;
                this.is_vote = true;
            }else this.is_vote = false;
        },
        votePercentage(ans){
            let total = this.jsonDecode(this.answer).length;
            let cc= this.jsonDecode(this.answer).map((item)=>{
                if (item.answer===ans) return item;
            }).filter(Boolean).length;
            if (total <=0 || cc <=0) return 0;
            else return parseFloat( (cc*100)/ total).toFixed(0);
        }
    },
    watch:{
        answer(){
            this.isVote();
        }
    }
}
</script>
