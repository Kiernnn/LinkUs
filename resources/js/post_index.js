const dots = document.querySelectorAll('.dots');
const actions = document.querySelectorAll('.actions');

dots.forEach((dot) => {
  dot.addEventListener('click', (event) => {
    const postActions = event.target.parentNode; // Get the parent element (.post-actions)
    const action = postActions.querySelector('.actions'); // Get the .actions element inside .post-actions
    action.classList.toggle('show');
  });
});