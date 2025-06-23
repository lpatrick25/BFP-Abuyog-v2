(function () {
    "use strict";

    let currentTab = 0;
    const steps = ["establishment", "application", "requirements", "confirm"];
    const fieldsets = document.querySelectorAll("fieldset");
    let isFSICChecked = false;

    const ActiveTab = (n) => {
        steps.forEach((step, index) => {
            const element = document.getElementById(step);
            if (index < n) {
                element.classList.add("done");
            } else if (index === n) {
                element.classList.add("active");
                element.classList.remove("done");
            } else {
                element.classList.remove("done", "active");
            }
        });
    };

    const showTab = (n) => {
        fieldsets.forEach((fieldset, index) => {
            fieldset.style.display = index === n ? "block" : "none";
        });
        ActiveTab(n);
    };

    const validateCurrentStep = () => {
        let isValid = true;
        let missingFields = [];

        fieldsets[currentTab].querySelectorAll("input[required], select[required], textarea[required]").forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                let label = input.closest(".form-group")?.querySelector("label")?.textContent || "Unknown Field";
                missingFields.push(label);

                let inputElement = $(input);

                if (inputElement.length > 0) {
                    inputElement.addClass('is-invalid');

                    inputElement.next('.invalid-feedback').remove();

                    let errorContainer = $('<div class="invalid-feedback">This field is required.</div>');
                    inputElement.after(errorContainer);

                    inputElement.off('input').on('input', function () {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                }
            }
        });

        if (!isValid) {
            showToast("danger", "Please fill out the required fields:\n" + missingFields.join("\n"));
        }

        return isValid;
    };

    const nextBtnFunction = async (n) => {
        if (n === 1 && !validateCurrentStep()) return;

        const establishmentId = document.getElementById("establishment_id")?.value;
        if (!establishmentId) {
            showToast('danger', 'Please select an establishment first.')
            return;
        }

        fieldsets[currentTab].style.display = "none";
        currentTab += n;

        if (currentTab >= steps.length) return;

        if (currentTab === 1 && !isFSICChecked) {
            isFSICChecked = true;

            fetch(`/client/getEstablishmentApplication/${establishmentId}`)
                .then(response => response.json())
                .then(data => {
                    const { haveFSICApplication, haveFSICExpired } = data;

                    if (!haveFSICApplication && !haveFSICExpired) {
                        document.querySelector("#fsic_type option[value='2']")?.remove();
                    }
                    if (haveFSICApplication && !haveFSICExpired) {
                        document.querySelector("#fsic_type option[value='1']")?.remove();
                        document.querySelector("#fsic_type option[value='2']")?.remove();
                    }
                    if (haveFSICApplication && haveFSICExpired) {
                        document.querySelector("#fsic_type option[value='1']")?.remove();
                    }
                    document.getElementById("fsic_type").dispatchEvent(new Event("change"));
                })
                .catch(error => {
                    console.error("Error fetching FSIC data:", error);
                    showToast("danger", "Something went wrong.");
                });
        }

        if (currentTab === 3) {
            let timerInterval = showLoadingDialog('Submitting Application');

            const formData = new FormData(document.getElementById('form-wizard1'));

            try {
                const response = await $.ajax({
                    method: 'POST',
                    url: '/applications',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: 'JSON'
                });

                clearInterval(timerInterval);
                Swal.close();
                showToast('success', 'Success');

                let progress = 0;
                const progressBar = document.getElementById("progress-bar");

                const interval = setInterval(() => {
                    progress += 2;
                    progressBar.style.width = progress + "%";
                    progressBar.textContent = progress + "%";

                    if (progress >= 100) {
                        clearInterval(interval);

                        window.location.href = "/client/applicationList";
                    }
                }, 100); // Runs every 100ms (100ms * 50 = 5000ms or 5 seconds)

            } catch (error) {
                clearInterval(timerInterval);
                Swal.close();
                nextBtnFunction(-1);

                showToast('danger', error.responseJSON?.message || 'Something went wrong.');
                return;
            }
        }

        showTab(currentTab);
    };

    document.querySelectorAll(".next").forEach(button => {
        button.addEventListener("click", () => nextBtnFunction(1));
    });

    document.querySelectorAll(".previous").forEach(button => {
        button.addEventListener("click", () => nextBtnFunction(-1));
    });

    showTab(currentTab);
})();
