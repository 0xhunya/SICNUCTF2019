#include <stdio.h>
#include <string.h>
extern "C"
{
	#include "miracl.h"
}
#include "mirdef.h"
#pragma comment(lib,"ms32.lib")

//esWWyNQAtz74m0WA8fcp
char *base64_code = "sicnu406HUNYAWXSTVdefBCDLMEF_2PQqrtv357ZabOwxyzRGIJKghjklm*p891o";
unsigned char base64_value[256] = {0};
char *RIGHT = "f75ZE6Tr";	//Right!
char *WRONG = "BkURF7_r";	//Wrong!
void base64_init(void)
{
    int i;
    for (i = 0; i < 256; i++)
	{
		base64_value[i] = 255;
	}
    for (i = 0; i < 64; i++)
	{
		base64_value[(int) base64_code[i]] = i;
	}
    base64_value['='] = 254;
	base64_value[' '] = base64_value['\n'] = base64_value['\r'] = 253;
}

int base64_decode(const unsigned char *in, unsigned char *out)
{
	
	unsigned long t, x, y, z;
	unsigned char c;
	int	g = 3;
	base64_init();
	for (x = y = z = t = 0; in[x]!=0;) {
		// 需要解码的数据对应的ASCII值对应base64_suffix_map的值
		c = base64_value[in[x++]];
		if (c == 255) return -1;	// 对应的值不在转码表中
		if (c == 253) continue;		// 对应的值是换行或者回车
		if (c == 254) { c = 0; g--; }	// 对应的值是'='
		t = (t<<6)|c;		// 将其依次放入一个int型中占3字节
		if (++y == 4) {
			out[z++] = (unsigned char)((t>>16)&255);
			if (g > 1) out[z++] = (unsigned char)((t>>8)&255);
			if (g > 2) out[z++] = (unsigned char)(t&255);
			y = t = 0;
		}
	}
	return z;
}

int base64_encode( unsigned char *in, unsigned char *out)
{
	unsigned long len = strlen((char *)in);
   	unsigned long i, len2, leven;
   	unsigned char *p;
    /* valid output size ? */
   	len2 = 4 * ((len + 2) / 3);
   	p = out;
   	leven = 3*(len / 3);
   	for (i = 0; i < leven; i += 3) {
       	*p++ = base64_code[in[0] >> 2];
       	*p++ = base64_code[((in[0] & 3) << 4) + (in[1] >> 4)];
       	*p++ = base64_code[((in[1] & 0xf) << 2) + (in[2] >> 6)];
       	*p++ = base64_code[in[2] & 0x3f];
       	in += 3;
   	}
   	/* Pad it if necessary...  */
   	if (i < len) {
       	unsigned a = in[0];
       	unsigned b = (i+1 < len) ? in[1] : 0;
       	unsigned c = 0;
 
       	*p++ = base64_code[a >> 2];
       	*p++ = base64_code[((a & 3) << 4) + (b >> 4)];
       	*p++ = (i+1 < len) ? base64_code[((b & 0xf) << 2) + (c >> 6)] : '=';
       	*p++ = '=';
   	}
 
   	/* append a NULL byte */ 
   	*p = '\0';
 
   	return p - out;

}

//n以内的素数
int prime_table(unsigned int n,int out[])
{
	unsigned int i,j;
	int index = 0;
	int flag = 1;
	for(i = 3; i <= n;i++)
	{
		for(j = 2;j <= i / 2;j++)
		{
			if(i % j ==0)
			{
				flag = 0;
				break;
			}
		}
		if(flag == 1)
		{
			out[index++] = i;
		}
		flag = 1;
	}
	return index;
}

void GetBody(unsigned char input[],unsigned char inpBody[])
{
	strncpy((char *)inpBody, (char *)&input[9], 20);

}


//n =3 * 5 * 7 * 11 * 13 * 17 * 19 * 23 * 29 * 31 * 37 * 41 * 43 * 47 * 53 * 59 * 61*67*71*73*79*83*89*97=1152783981972759212376551073665878035
//e = 233
//d = gmpy2.invert(e, phi_n)=214300190030012065199803369533527897
//c = m^e mod n   
//m = 0x4c034db4a7cc8ae985e4634cf140bbL
//c = 66
int check(unsigned char input[])
{
	unsigned char out[50] = {0};
	unsigned char tmp1[50] = {0};
	int result;
	miracl *mip =mirsys(400,16);  
	big m=mirvar(0);		//m明文
    big c=mirvar(0);		//c密文
    big n=mirvar(1);		//n模数
    big e=mirvar(233);		//e公钥
	mip->IOBASE = 16;
	int pri_table[50]={0};
	int i=0,len=0;
	//n =3 * 5 * 7 * 11 * 13 * 17 * 19 * 23 * 29 * 31 * 37 * 41 * 43 * 47 * 53 * 59 * 61*67*71*73*79*83*89*97=1152783981972759212376551073665878035
	
	//100以内质数相乘
	len = prime_table(100,pri_table);
	for(i = 0;i<len;i++)
	{
		premult(n,pri_table[i],n);
	}
	base64_decode(input,out);
	//\x4c\x03\x4d\xb4\xa7\xcc\x8a\xe9\x85\xe4\x63\x4c\xf1\x40\xbb

	bytes_to_big(15, (char *)out,m);
	powmod(m,e,n,c);
	if(c->len > 2){
		base64_decode((const unsigned char *)WRONG,(unsigned char *)tmp1);
		result = 0;
	}
	else{
		result = int(*(c->w));
	}

	mirkill(m);
    mirkill(c);
    mirkill(n);
    mirkill(e);
    mirexit();
//	printf("%d",result);
	return result;
}


int main()
{
	unsigned char input[50] = {0};
	unsigned char de_inp[50] = {0};
	unsigned char tmp[50] = {0};
	unsigned char tmp1[50] = {0};

	int flag=0 ;

	printf("Welcome to 8th SICNUCTF!\nPlz input : ");
	scanf("%s",input);
	//sicnuctf{esWWyNQAtz74m0WA8fcp}
	if(strlen((char *)input) != 30 ||memcmp("sicnuctf{",input,9)!=0 || input[29] != '}')
	{
		base64_decode((const unsigned char *)WRONG,(unsigned char *)tmp1);
		printf("%s\n",tmp1);
		return 0;
	}
	unsigned char inpBody[25]={0};
	GetBody(input,inpBody);
	flag = check(inpBody);	
	if (flag == 66)
	{
		base64_decode((const unsigned char *)RIGHT,(unsigned char *)tmp1);
		printf("%s\n",tmp1);
	}
	else
	{
		base64_decode((const unsigned char *)WRONG,(unsigned char *)tmp1);
		printf("%s\n",tmp1);
	}

	return 0;
}