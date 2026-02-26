export function initMorhenaTabs(root) {
    const buttons = root.querySelectorAll('[data-tab-target]');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-tab-target');

            buttons.forEach((element) => element.classList.remove('active'));
            root.querySelectorAll('.tab').forEach((tab) => tab.classList.remove('active'));

            button.classList.add('active');
            root.querySelector(`#tab-${target}`)?.classList.add('active');
        });
    });
}
