import { useState } from 'react';

export default function Hola() {
    const [n, setN] = useState(0);

    return <button className="rounded bg-red-600 px-3 py-0 text-white" onClick={() => setN(n + 1)}>React funciona: {n}</button>;
}