@include('layouts.header')
<style>
    .g-recaptcha{
        text-align: center;
        display: flex;
        justify-content: center;
    }
    #form-change-password .input-group-text.togglePassword{
        z-index: 1;
    }
    div#form-change-password.loading:before {
        pointer-events: all;
        content: "";
        display: flex;
        flex: 1;
        width: 100%;
        height: 100%;
        z-index: 2;
        position: absolute;
        left: 0;
        top: 0;
        background: rgb(0 0 0 / 30%);
    }
    div#form-change-password.loading:after{
        content: '';
        position: absolute;
        top: calc(50% - 40px);
        left: calc(50% - 40px);
        width: 40px;
        height: 40px;
        transform: translate(-50%, -50%);
        border: 3px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 2;
    }
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
@yield('content')
@include('layouts.footer')