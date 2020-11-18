<template>
    <div>
        <button type="button" class="btn btn-danger btn-sm rounded" @click="$modal.show('confirm')">Delete</button>
        <modal name="confirm"
                classes="p-4 rounded-lg"
                height="auto"
                :focusTrap="true"
                :shiftX="0.5"
                :shiftY="0.5">
            <h6 class="d-flex justify-content-center">Are you sure you want to delete this ad? The slot remains occupied 30 days after the ad has been posted.</h6><br>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-info rounded mr-3" @click="$modal.hide('confirm')">Cancel</button>
                <button type="submit" class="btn border-custom">Yes, I'm sure</button>
            </div>
        </modal>
    </div>
</template>
