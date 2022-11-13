export function Csrf() {
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    return <input type="hidden" name="_token" value={csrf} />;
}
