package donggua.cm.demo1ctf;

public class JNIUtil {

    static {
        System.loadLibrary("JniLib");
    }

    public native String en(String code);
}
