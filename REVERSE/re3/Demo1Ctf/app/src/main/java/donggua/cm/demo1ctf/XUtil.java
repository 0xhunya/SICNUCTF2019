package donggua.cm.demo1ctf;

import java.util.Map;

import io.jsonwebtoken.Jwt;
import io.jsonwebtoken.Jwts;

class XUtil {

    private static final String X_SECRET_KEY = "ODA0OHh1ZWppZW5paGFvYmFuZ28=";

    private static final String X_ENCRYPTION_VALUE = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ2YWx1ZSI6IlV3VnFvcXFHbFdYYXNsS0tiYkhjYk9JcXFxVHdZWVlsZWxERyJ9.9Ww7ljgKk7AmMdncrhn3DIXyiXQ2VS7Q4IIuO7usVTE";

    private XUtil() {
    }

    private static XUtil INSTANCE = null;

    static XUtil getInstance() {
        if (INSTANCE == null) {
            INSTANCE = new XUtil();
        }
        return INSTANCE;
    }

    public String getXValue() {
        Jwt parse = Jwts.parser().setSigningKey(X_SECRET_KEY).parse(X_ENCRYPTION_VALUE);
        Map<String, String> map1 = (Map<String, String>) parse.getBody();
        String xValue = map1.get("value");
        return xValue;
    }

    boolean check(String code) {
        return new JNIUtil().en(code).equals(getXValue());
    }
}
