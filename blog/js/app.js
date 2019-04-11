/** Blog page filter functionality. */

class Blog {
  constructor() {
    this.items = document.querySelectorAll('.blog-grid__item');
    document.querySelectorAll('.blog-filter__item').forEach(item => {
      item.addEventListener('click', evt => {
        const target = evt.currentTarget;

        // hide or show blog items
        if (target.classList.contains('active')) {
          target.classList.remove('active');
          this.items.forEach(item => {
            item.classList.remove('blog-grid__item--hidden');
          });
        } else {
          document.querySelectorAll('.blog-filter__item.active').forEach(e => { e.classList.remove('active'); });
          target.classList.add('active');
          const filter = target.dataset['filter'].toLowerCase();
          this.items.forEach(item => {
            const f = item.dataset['filter'];
            if (!(f && f.toLowerCase().indexOf(filter) != -1)) {
              item.classList.add('blog-grid__item--hidden');
            } else {
              item.classList.remove('blog-grid__item--hidden');
            }
          })
        }
      });
    });
  }
}

window.addEventListener('load', () => {
  const blog = new Blog();
});
