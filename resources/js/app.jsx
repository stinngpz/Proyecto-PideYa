import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

const components = import.meta.glob('./components/*.jsx', { eager: true });

document.querySelectorAll('[data-react]').forEach((el) => {
    const module = components[`./components/${el.dataset.react}.jsx`];
    if (!module) return;

    const Component = module.default;
    const props = el.dataset.props ? JSON.parse(el.dataset.props) : {};

    createRoot(el).render(<Component {...props} />);
});
