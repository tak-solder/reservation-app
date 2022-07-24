export const alertVariants = {
  error: {
    label: "エラー",
    accentColor: "red.400",
  },
  warning: {
    label: "注意",
    accentColor: "yellow.400",
  },
  success: {
    label: "完了",
    accentColor: "green.400",
  },
} as const;

export type AlertVariant = keyof typeof alertVariants;
