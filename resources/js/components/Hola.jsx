import { useState } from 'react';

export default function Hola() {
    const [n, setN] = useState(0);

    return <button onClick={() => setN(n + 1)}>React funciona: {n}</button>;
}