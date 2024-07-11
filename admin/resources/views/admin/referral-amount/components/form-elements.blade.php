<div class="form-group row align-items-center" :class="{'has-danger': errors.has('referral_amount'), 'has-success': fields.referral_amount && fields.referral_amount.valid }">
    <label for="referral_amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.referral-amount.columns.referral_amount') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.referral_amount" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('referral_amount'), 'form-control-success': fields.referral_amount && fields.referral_amount.valid}" id="referral_amount" name="referral_amount" placeholder="{{ trans('admin.referral-amount.columns.referral_amount') }}">
        <div v-if="errors.has('referral_amount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('referral_amount') }}</div>
    </div>
</div>


