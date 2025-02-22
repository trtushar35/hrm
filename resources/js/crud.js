import 'toastr/build/toastr.css';
import toastr from 'toastr';
toastr.options = {
    closeButton: true,
    progressBar: true,
};

export const handleFormSubmission = (form, successCallback, errorCallback, useDefaultCallBackFunction) => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route(routeUrl), {
        onFinish: () => form.reset(),
        onSuccess: (response) => {
            if (useDefaultCallBackFunction) {
                defaultSuccessHandler(response);
            }
            else if (typeof successCallback === 'function') {
                successCallback(response);
            }
            return response;
        },
        onError: (error) => {
            if (typeof errorCallback === 'function') {
                errorCallback(error);
            } else {
                defaultErrorHandler(error);
            }
        },
    });
};

export const defaultSuccessHandler = (response) => {
    if (response.message) {
        toastr.success(response.message);
        if (response.redirectUrl) {
            inertia.visit(response.redirectUrl);
        }
    } else if (response.warningMessage) {
        toastr.warning(response.warningMessage);
        if (response.redirectUrl) {
            inertia.visit(response.redirectUrl);
        }
    } else if (response.errorMessage) {
        toastr.warning(response.errorMessage);
        if (response.redirectUrl) {
            inertia.visit(response.redirectUrl);
        }
    }
};

export const defaultErrorHandler = (error) => {
    toastr.error('An error occurred.');
};
